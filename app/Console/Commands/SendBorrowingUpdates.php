<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use App\Models\BorrowingEmailUpdate;
use App\Services\BorrowingEmails;
use Illuminate\Console\Command;

class SendBorrowingUpdates extends Command
{
    protected $signature = 'borrowings:send-updates';

    protected $description = 'Send due-date reminders and retry undelivered borrowing updates';

    public function handle(BorrowingEmails $emails): int
    {
        Borrowing::whereIn('status', ['borrowed', 'overdue'])
            ->whereNull('date_returned')->whereDate('due_date', '<=', today())
            ->chunkById(100, function ($borrowings) use ($emails): void {
                foreach ($borrowings as $borrowing) {
                    $borrowing->markOverdueIfNeeded();
                    $emails->record($borrowing, $borrowing->due_date->isToday() ? 'due' : 'overdue');
                }
            });

        $pending = 0;
        BorrowingEmailUpdate::whereNull('sent_at')->whereNull('cancelled_at')
            ->chunkById(100, function ($updates) use ($emails, &$pending): void {
                foreach ($updates as $update) {
                    if (! $emails->send($update)) {
                        $pending++;
                    }
                }
            });

        $this->info("Borrowing email check complete. {$pending} update(s) awaiting delivery.");

        return self::SUCCESS;
    }
}
