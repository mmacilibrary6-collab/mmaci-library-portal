<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_BORROWED = 'borrowed';
    public const STATUS_RETURNED = 'returned';
    public const STATUS_OVERDUE = 'overdue';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'borrower_id',
        'new_arrival_id',
        'accession_number',
        'bibliographical_description',
        'date_borrowed',
        'due_date',
        'date_returned',
        'status',
        'received_by',
        'returned_by',
        'remarks',
        'approved_by',
        'returned_processed_by',
    ];

    protected $casts = [
        'date_borrowed' => 'date',
        'due_date' => 'date',
        'date_returned' => 'date',
    ];

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(Borrower::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(NewArrival::class, 'new_arrival_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function returnProcessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_processed_by');
    }

    public function getDisplayStatusAttribute(): string
    {
        if (
            in_array($this->status, [self::STATUS_BORROWED, self::STATUS_APPROVED], true) &&
            blank($this->date_returned) &&
            $this->due_date &&
            $this->due_date->isPast() &&
            ! $this->due_date->isToday()
        ) {
            return self::STATUS_OVERDUE;
        }

        return $this->status;
    }

    public function scopeActiveForBook(Builder $query, string $accessionNumber): Builder
    {
        return $query
            ->where('accession_number', $accessionNumber)
            ->whereIn('status', [
                self::STATUS_PENDING,
                self::STATUS_APPROVED,
                self::STATUS_BORROWED,
                self::STATUS_OVERDUE,
            ])
            ->whereNull('date_returned');
    }

    public function markOverdueIfNeeded(): bool
    {
        if (
            in_array($this->status, [self::STATUS_APPROVED, self::STATUS_BORROWED], true) &&
            blank($this->date_returned) &&
            $this->due_date instanceof Carbon &&
            $this->due_date->isPast() &&
            ! $this->due_date->isToday()
        ) {
            $this->forceFill(['status' => self::STATUS_OVERDUE])->save();

            return true;
        }

        return false;
    }
}
