<?php

namespace Tests\Feature;

use App\Models\DonatedBook;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DonatedBooksPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'http://localhost']);
        app('url')->forceRootUrl('http://localhost');

        // Isolate these rendering tests from both local data and unrelated migrations.
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        $migration = require database_path('migrations/2026_08_03_000001_create_donated_books_table.php');
        $migration->up();
    }

    public function test_public_page_renders_published_records_and_excludes_hidden_books(): void
    {
        $book = DonatedBook::create([
            'title' => 'Donated Maritime Handbook',
            'description' => 'A donated reference for navigation students.',
            'image' => 'stored-image-bytes',
            'status' => true,
            'sort_order' => 0,
        ]);
        DonatedBook::create(['title' => 'Unpublished Donation', 'status' => false]);

        $this->get(route('collection.donated-books'))
            ->assertOk()
            ->assertSeeText($book->title)
            ->assertSeeText($book->description)
            ->assertSee($book->image_url)
            ->assertDontSeeText('Unpublished Donation')
            ->assertDontSeeText('Donated books will appear here');

        $book->update(['title' => 'Updated Donation Title', 'description' => '<script>alert(1)</script>']);

        $this->get(route('collection.donated-books'))
            ->assertOk()
            ->assertSeeText('Updated Donation Title')
            ->assertDontSeeText('Donated Maritime Handbook')
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_empty_state_only_appears_when_no_books_are_published(): void
    {
        DonatedBook::create(['title' => 'Hidden Donation', 'status' => false]);

        $this->get(route('collection.donated-books'))
            ->assertOk()
            ->assertSeeText('Donated books will appear here')
            ->assertDontSeeText('Hidden Donation');
    }

    public function test_a_published_book_without_an_image_still_displays_with_a_fallback(): void
    {
        DonatedBook::create(['title' => 'Donation Without Cover', 'status' => true]);

        $this->get(route('collection.donated-books'))
            ->assertOk()
            ->assertSeeText('Donation Without Cover')
            ->assertSee(asset('images/image-fallback.svg'))
            ->assertDontSeeText('Donated books will appear here');
    }
}
