<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use ZipArchive;

class BookExportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        app('url')->forceRootUrl('http://localhost');
        DB::purge('sqlite');
        Schema::create('new_arrivals', function (Blueprint $table) {
            $table->id();
            foreach (['accession_number', 'title', 'author', 'isbn', 'category', 'publication_year', 'publisher', 'description', 'availability_status', 'arrival_date'] as $column) {
                $table->string($column)->nullable();
            }
            $table->timestamps();
        });
        (require database_path('migrations/2026_08_03_000001_create_donated_books_table.php'))->up();
        foreach (range(1, 15) as $number) {
            DB::table('new_arrivals')->insert(['title' => 'Book '.$number, 'accession_number' => sprintf('%05d', $number), 'availability_status' => $number === 1 ? 'unavailable' : 'available']);
            DB::table('donated_books')->insert(['title' => 'Book '.$number, 'description' => '=1+1', 'status' => $number !== 1]);
        }
    }

    private function rows(string $collection, array $filters = []): array
    {
        $response = $this->get(route('admin.book-export', ['collection' => $collection] + $filters))->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $path = $response->baseResponse->getFile()->getPathname();
        $zip = new ZipArchive;
        $this->assertTrue($zip->open($path));
        try {
            $xml = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml'));
            $xml->registerXPathNamespace('s', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $this->assertCount(0, $xml->xpath('//s:f'));
            return array_map(fn ($row) => array_map(fn ($cell) => (string) $cell->is->t, iterator_to_array($row->c, false)), iterator_to_array($xml->sheetData->row, false));
        } finally {
            $zip->close();
            unlink($path);
        }
    }

    public function test_exports_include_all_pages_and_respect_filters(): void
    {
        $this->actingAs(new User(['name' => 'Admin']));
        foreach (['new-arrivals', 'donated-books'] as $collection) {
            $this->assertCount(16, $this->rows($collection));
            $this->assertCount(2, $this->rows($collection, ['search' => 'Book 15']));
            $this->assertCount(1, $this->rows($collection, ['search' => 'missing']));
            $this->get(route('admin.'.$collection.'.index'))->assertOk()->assertSeeText('Export to Excel');
        }
        $rows = $this->rows('new-arrivals', ['availability_status' => 'unavailable']);
        $this->assertCount(2, $rows);
        $this->assertSame('00001', $rows[1][0]);
        $this->assertSame(['Book 1', '=1+1', 'Inactive'], $this->rows('donated-books')[1]);
    }

    public function test_exports_require_authentication_and_validate_filters(): void
    {
        foreach (['new-arrivals', 'donated-books'] as $collection) {
            $this->get(route('admin.book-export', $collection))->assertRedirect(route('login'));
        }
        $this->actingAs(new User(['name' => 'Admin']));
        $this->getJson(route('admin.book-export', ['collection' => 'new-arrivals', 'availability_status' => 'invalid']))->assertUnprocessable();
        $this->getJson(route('admin.book-export', ['collection' => 'donated-books', 'search' => ['invalid']]))->assertUnprocessable();
    }
}
