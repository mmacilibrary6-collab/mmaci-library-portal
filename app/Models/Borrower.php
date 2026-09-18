<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_number',
        'borrower_type',
        'borrower_type_other',
        'contact_number',
        'department',
        'semester',
        'email',
    ];

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function getBorrowerTypeLabelAttribute(): string
    {
        return match ($this->borrower_type) {
            'student' => 'Student',
            'faculty' => 'Faculty',
            'other' => $this->borrower_type_other ?: 'Other',
            default => 'Not Set',
        };
    }
}
