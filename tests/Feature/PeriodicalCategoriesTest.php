<?php

namespace Tests\Feature;

use App\Models\PeriodicalFolder;
use App\Models\PeriodicalProgram;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PeriodicalCategoriesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        app('url')->forceRootUrl('http://localhost');
        DB::purge('sqlite');
        foreach ([
            '2026_08_04_000005_create_periodical_programs_table.php',
            '2026_08_04_000006_create_periodical_folders_table.php',
            '2026_08_04_000009_add_category_to_periodical_folders_table.php',
            '2026_08_27_000001_add_accession_number_to_periodical_folders_table.php',
        ] as $file) {
            (require database_path('migrations/'.$file))->up();
        }
    }

    public function test_each_category_can_be_saved_and_filters_only_its_own_public_folders(): void
    {
        $this->actingAs(new User(['name' => 'Test Admin']));
        $program = PeriodicalProgram::create(['title' => 'Test Program', 'status' => true]);

        foreach (PeriodicalFolder::CATEGORIES as $key => $category) {
            $this->post(route('admin.periodical-folders.store'), [
                'periodical_program_id' => $program->id,
                'category' => $key,
                'title' => 'Fixture '.$key,
                'folder_link' => 'https://example.com/'.$key,
                'accession_number' => PeriodicalFolder::requiresAccession($key) ? '  '.$key.'-001  ' : '',
                'status' => '1',
            ])->assertSessionHasNoErrors()->assertRedirect(route('admin.periodical-folders.index'));
        }

        $this->assertSame(6, PeriodicalFolder::count());
        foreach (PeriodicalFolder::CATEGORIES as $key => $category) {
            $response = $this->get(route('collection.periodicals', ['category' => $key]))
                ->assertOk()->assertSeeText($category['description'])->assertSeeText('Fixture '.$key);
            foreach (array_keys(PeriodicalFolder::CATEGORIES) as $other) {
                if ($other !== $key) {
                    $response->assertDontSeeText('Fixture '.$other);
                }
            }
        }
    }

    public function test_migration_preserves_existing_record_fields_and_old_category_links(): void
    {
        $program = PeriodicalProgram::create(['title' => 'Existing Program', 'status' => true]);
        $folder = PeriodicalFolder::create([
            'periodical_program_id' => $program->id, 'category' => 'journal_newspaper',
            'accession_number' => 'JRN-0001', 'title' => 'Existing Journal',
            'description' => 'Existing description', 'folder_link' => 'https://example.com/journal', 'status' => true,
        ]);
        $before = $folder->fresh()->getAttributes();
        (require database_path('migrations/2026_09_10_000001_split_periodical_folder_categories.php'))->up();
        $this->assertSame(array_replace($before, ['category' => 'journal']), $folder->fresh()->getAttributes());
        $this->assertSame(1, PeriodicalFolder::count());
        $this->get(route('collection.periodicals', ['category' => 'journal_newspaper']))
            ->assertOk()->assertSeeText('Existing Journal')->assertSeeText('JRN-0001');
    }

    public function test_invalid_categories_and_duplicate_accessions_are_rejected(): void
    {
        $this->actingAs(new User(['name' => 'Test Admin']));
        $program = PeriodicalProgram::create(['title' => 'Test Program']);
        $data = ['periodical_program_id' => $program->id, 'title' => 'Journal One',
            'category' => 'journal', 'accession_number' => 'JRN-0001', 'folder_link' => 'https://example.com'];
        $this->post(route('admin.periodical-folders.store'), $data)->assertSessionHasNoErrors();
        $this->post(route('admin.periodical-folders.store'), array_replace($data, [
            'title' => 'Journal Two', 'accession_number' => '  jrn-0001  ',
        ]))->assertSessionHasErrors('accession_number');
        $this->post(route('admin.periodical-folders.store'), array_replace($data, [
            'category' => 'unsupported',
        ]))->assertSessionHasErrors('category');
        $this->get(route('collection.periodicals', ['category' => 'unsupported']))->assertNotFound();
    }

    public function test_an_admin_can_reclassify_a_journal_as_a_newspaper_without_losing_its_accession(): void
    {
        $this->actingAs(new User(['name' => 'Test Admin']));
        $program = PeriodicalProgram::create(['title' => 'Test Program']);
        $folder = PeriodicalFolder::create([
            'periodical_program_id' => $program->id, 'category' => 'journal',
            'title' => 'Existing Folder', 'folder_link' => 'https://example.com/paper',
            'accession_number' => 'JRN-0001', 'status' => true,
        ]);
        $this->put(route('admin.periodical-folders.update', $folder), array_replace($folder->toArray(), [
            'category' => 'newspaper', 'status' => '1',
        ]))->assertSessionHasNoErrors()->assertRedirect();
        $this->assertSame('newspaper', $folder->fresh()->category);
        $this->assertSame('JRN-0001', $folder->fresh()->accession_number);
        $this->get(route('collection.periodicals', ['category' => 'newspaper']))
            ->assertOk()->assertSeeText('Existing Folder')->assertSeeText('JRN-0001');
        $this->get(route('collection.periodicals', ['category' => 'journal']))
            ->assertOk()->assertDontSeeText('Existing Folder');
    }
}
