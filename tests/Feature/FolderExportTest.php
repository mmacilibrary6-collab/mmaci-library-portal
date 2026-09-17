<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use ZipArchive;

class FolderExportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        app('url')->forceRootUrl('http://localhost');
        DB::purge('sqlite');
        foreach (['ebook', 'thesis', 'periodical'] as $type) {
            Schema::create($type.'_programs', function (Blueprint $table) {
                $table->id(); $table->string('title'); $table->timestamps();
            });
            Schema::create($type.'_folders', function (Blueprint $table) use ($type) {
                $table->id(); $table->unsignedBigInteger($type.'_program_id')->nullable();
                $table->string('title'); $table->text('description')->nullable();
                $table->text($type === 'periodical' ? 'folder_link' : 'drive_link')->nullable();
                if ($type === 'periodical') {
                    $table->string('category'); $table->string('accession_number')->nullable();
                }
                $table->boolean('status')->default(true); $table->timestamps();
            });
            DB::table($type.'_programs')->insert([['id' => 1, 'title' => 'Education'], ['id' => 2, 'title' => 'Computing'], ['id' => 3, 'title' => 'Business']]);
            foreach (range(1, 13) as $number) {
                $data = [$type.'_program_id' => $number <= 6 ? 1 : ($number <= 12 ? 2 : 3), 'title' => sprintf('Folder %02d', $number), 'description' => 'Research & learning', $type === 'periodical' ? 'folder_link' : 'drive_link' => 'https://example.com/'.$number, 'status' => $number !== 1];
                if ($type === 'periodical') {
                    $data += ['category' => $number % 2 ? 'journal' : 'newspaper', 'accession_number' => '000'.$number];
                }
                DB::table($type.'_folders')->insert($data);
            }
        }
    }

    private function workbook(string $collection, array $filters = []): array
    {
        $response = $this->get(route('admin.folder-export', ['collection' => $collection] + $filters));
        $response->assertOk()->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->assertStringContainsString('.xlsx', $response->headers->get('Content-Disposition'));
        $path = $response->baseResponse->getFile()->getPathname();
        $zip = new ZipArchive;
        $this->assertTrue($zip->open($path));
        try {
            foreach (['[Content_Types].xml', '_rels/.rels', 'xl/workbook.xml', 'xl/_rels/workbook.xml.rels', 'xl/styles.xml', 'xl/worksheets/sheet1.xml'] as $part) {
                $this->assertNotFalse(simplexml_load_string($zip->getFromName($part)));
            }
            $xml = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml'));
            $xml->registerXPathNamespace('s', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $this->assertCount(0, $xml->xpath('//s:f'));
            return array_map(fn ($row) => array_map(fn ($cell) => (string) $cell->is->t, iterator_to_array($row->c, false)), iterator_to_array($xml->sheetData->row, false));
        } finally {
            $zip->close();
            unlink($path);
        }
    }

    public function test_all_three_exports_include_every_page_and_multiple_program_selections(): void
    {
        $this->actingAs(new User(['name' => 'Admin']));
        foreach (['ebooks' => 'ebook', 'theses' => 'thesis', 'periodicals' => 'periodical'] as $collection => $type) {
            $rows = $this->workbook($collection);
            $this->assertCount(14, $rows);
            $this->assertSame('Folder 13', $rows[13][0]);
            $filtered = $this->workbook($collection, ['programs' => [1, 3]]);
            $this->assertCount(8, $filtered);
            $this->assertNotContains('Computing', array_column(array_slice($filtered, 1), 1));
            $this->get(route('admin.'.$type.'-folders.index'))->assertOk()->assertSeeText('Export to Excel')->assertSeeText('Export All Folders');
        }
    }

    public function test_categories_combine_with_program_and_search_filters(): void
    {
        $this->actingAs(new User(['name' => 'Admin']));
        $rows = $this->workbook('periodicals', ['programs' => [1], 'categories' => ['journal']]);
        $this->assertCount(4, $rows);
        $this->assertSame(['Folder 01', 'Education', 'Journals', '0001'], array_slice($rows[1], 0, 4));
        $this->assertCount(7, $this->workbook('periodicals', ['programs' => [1], 'categories' => ['journal', 'newspaper']]));
        $this->assertCount(2, $this->workbook('periodicals', ['search' => '0001', 'programs' => [1], 'categories' => ['journal']]));
        $this->assertCount(1, $this->workbook('periodicals', ['search' => 'does not exist']));
    }

    public function test_cell_text_is_preserved_without_executable_formulas(): void
    {
        $this->actingAs(new User(['name' => 'Admin']));
        DB::table('ebook_folders')->where('id', 1)->update(['title' => '=HYPERLINK("https://example.com")', 'description' => "Résumé & <notes>\nSecond line"]);
        $rows = $this->workbook('ebooks', ['search' => '=HYPERLINK']);
        $this->assertSame('=HYPERLINK("https://example.com")', $rows[1][0]);
        $this->assertSame("Résumé & <notes>\nSecond line", $rows[1][2]);
        $this->assertContains('Inactive', $rows[1]);
    }

    public function test_exports_require_authentication_and_validate_filters(): void
    {
        foreach (['ebooks', 'theses', 'periodicals'] as $collection) {
            $this->get(route('admin.folder-export', $collection))->assertRedirect(route('login'));
        }
        $this->actingAs(new User(['name' => 'Admin']));
        $this->getJson(route('admin.folder-export', ['collection' => 'periodicals', 'categories' => ['invalid']]))->assertUnprocessable();
        $this->getJson(route('admin.folder-export', ['collection' => 'ebooks', 'programs' => [999]]))->assertUnprocessable();
        $this->getJson(route('admin.folder-export', ['collection' => 'ebooks', 'programs' => '1']))->assertUnprocessable();
        $this->getJson(route('admin.folder-export', ['collection' => 'ebooks', 'categories' => ['journal']]))->assertUnprocessable();
        $this->get('/admin/folder-exports/unknown')->assertNotFound();
    }
}

