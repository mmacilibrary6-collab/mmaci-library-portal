<?php

namespace App\Services;

use App\Models\Borrower;
use App\Models\Borrowing;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class BorrowingPolicy
{
    public static function limit(string $type): int
    {
        return match ($type) {
            'student' => 3,
            'faculty' => 10,
            default => throw ValidationException::withMessages(['borrower_type' => 'Set the borrower type to Student or Faculty before lending books.']),
        };
    }

    public static function dueDate(string $type, string $start): Carbon
    {
        self::limit($type);
        $date = Carbon::parse($start)->startOfDay();

        return $type === 'faculty' ? $date->addMonthNoOverflow() : $date->addDays(2);
    }

    /** Call while holding the borrower row lock when changing a loan. */
    public static function assertCapacity(Borrower $borrower): void
    {
        $limit = self::limit((string) $borrower->borrower_type);
        $count = $borrower->borrowings()->whereIn('status', ['borrowed', 'overdue'])->whereNull('date_returned')->count();
        if ($count >= $limit) {
            throw ValidationException::withMessages(['borrower_type' => ucfirst($borrower->borrower_type)." borrowers may have at most {$limit} books on loan at a time. Return a book before borrowing another."]);
        }
    }

    public static function assertDates(string $type, string $start, string $due): void
    {
        $maximum = self::dueDate($type, $start);
        if (Carbon::parse($due)->startOfDay()->gt($maximum)) {
            $period = $type === 'faculty' ? '1 calendar month' : '2 days';
            throw ValidationException::withMessages(['due_date' => "The loan period cannot exceed {$period}. The latest due date is ".$maximum->toDateString().'.']);
        }
    }
}
