<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowingEmailUpdate extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['sent_at' => 'datetime', 'cancelled_at' => 'datetime'];

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }
}
