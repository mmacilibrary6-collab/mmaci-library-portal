<?php

namespace App\Console\Commands;

use App\Models\VisitorLog;
use Illuminate\Console\Command;

class PruneVisitorLogs extends Command
{
    protected $signature = 'visitor-logs:prune {--days=90 : Delete logs older than the given number of days}';

    protected $description = 'Delete stale visitor logs used for security monitoring';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $cutoff = now()->subDays($days);

        $deleted = VisitorLog::where('created_at', '<', $cutoff)->delete();

        $this->components->info("Deleted {$deleted} visitor log records older than {$days} days.");

        return self::SUCCESS;
    }
}
