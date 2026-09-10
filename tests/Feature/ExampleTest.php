<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.url' => 'http://localhost',
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        app('url')->forceRootUrl('http://localhost');

        DB::purge('sqlite');

        foreach ([
            '2026_07_23_064736_create_calendar_events_table.php',
            '2026_07_23_064736_create_new_arrivals_table.php',
            '2026_07_30_000002_create_library_updates_table.php',
            '2026_08_27_000001_create_visitor_logs_table.php',
        ] as $file) {
            (require database_path('migrations/' . $file))->up();
        }
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }
}
