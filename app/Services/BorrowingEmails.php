<?php

namespace App\Services;

use App\Mail\BorrowingUpdateMail;
use App\Models\Borrowing;
use App\Models\BorrowingEmailUpdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class BorrowingEmails
{
    public function record(Borrowing $borrowing, string $event): BorrowingEmailUpdate
    {
        $key = in_array($event, ['due', 'overdue'], true)
            ? $event.':'.$borrowing->due_date->toDateString()
            : $event;

        return BorrowingEmailUpdate::firstOrCreate(
            ['borrowing_id' => $borrowing->id, 'event_key' => $key],
            ['event' => $event],
        );
    }

    public function send(BorrowingEmailUpdate $update): bool
    {
        return DB::transaction(function () use ($update): bool {
            $update = BorrowingEmailUpdate::whereKey($update->id)->lockForUpdate()->first();
            if (! $update || $update->sent_at || $update->cancelled_at) {
                return true;
            }

            $borrowing = Borrowing::whereKey($update->borrowing_id)->lockForUpdate()->first();
            $borrowing?->load('borrower');
            if (! $borrowing || ! $this->isRelevant($borrowing, $update)) {
                $update->update(['cancelled_at' => now()]);
                return true;
            }

            if (! filter_var($borrowing->borrower?->email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }

            $update->increment('attempts');
            try {
                Mail::to($borrowing->borrower->email)->send(new BorrowingUpdateMail($borrowing, $update->event));
                $update->update(['sent_at' => now()]);
                return true;
            } catch (Throwable $exception) {
                report($exception);
                return false;
            }
        });
    }

    private function isRelevant(Borrowing $borrowing, BorrowingEmailUpdate $update): bool
    {
        if (in_array($update->event, ['approved', 'rejected'], true)) {
            return $borrowing->status === $update->event;
        }

        if (! in_array($borrowing->status, ['borrowed', 'overdue'], true) || $borrowing->date_returned || ! $borrowing->due_date) {
            return false;
        }

        return $update->event_key === $update->event.':'.$borrowing->due_date->toDateString()
            && ($update->event === 'due' ? $borrowing->due_date->isToday() : $borrowing->due_date->lt(today()));
    }
}
