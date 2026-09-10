<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class VisitorIpAddressTest extends TestCase
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
            '0001_01_01_000000_create_users_table.php',
            '2026_08_27_000001_create_visitor_logs_table.php',
        ] as $file) {
            (require database_path('migrations/' . $file))->up();
        }
    }

    public function test_clear_old_logs_removes_records_before_today_only(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-09-10 14:30:00'));

        try {
            VisitorLog::forceCreate([
                'ip_address' => '143.44.193.123',
                'url' => 'https://mmacilibrary.laravel.cloud',
                'method' => 'GET',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ]);

            VisitorLog::forceCreate([
                'ip_address' => '139.177.144.207',
                'url' => 'https://mmacilibrary.laravel.cloud/more/survey',
                'method' => 'GET',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->actingAs(User::factory()->create())
                ->post(route('admin.visitor-ip-address.prune'))
                ->assertRedirect(route('admin.visitor-ip-address.index'))
                ->assertSessionHas('success', '1 visitor logs before today deleted successfully.');

            $this->assertSame(1, VisitorLog::count());
            $this->assertSame('139.177.144.207', VisitorLog::first()->ip_address);
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_only_guest_requests_are_logged_as_visitors(): void
    {
        Route::middleware(\App\Http\Middleware\TrackVisitor::class)
            ->get('/visitor-log-auth-test', fn () => response('<html>ok</html>'));

        $this->actingAs(User::factory()->create())
            ->get('/visitor-log-auth-test')
            ->assertOk();

        $this->assertSame(0, VisitorLog::count());

        auth()->logout();

        $this->get('/visitor-log-auth-test')
            ->assertOk();

        $this->assertSame(1, VisitorLog::count());
    }
}
