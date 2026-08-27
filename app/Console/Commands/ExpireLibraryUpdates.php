<?php

namespace App\Console\Commands;

use App\Models\LibraryUpdate;
use Illuminate\Console\Command;

class ExpireLibraryUpdates extends Command
{
    protected $signature = 'library-updates:expire {--days=10 : Hide updates older than the given number of days}';

    protected $description = 'Automatically hide library updates that are older than the configured age limit';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $cutoff = now()->subDays($days);

        $expiredCount = LibraryUpdate::query()
            ->where('status', true)
            ->where('created_at', '<', $cutoff)
            ->update(['status' => false]);

        $this->components->info("Hidden {$expiredCount} library update(s) older than {$days} days.");

        return self::SUCCESS;
    }
}
