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
        'contact_number',
        'department',
        'semester',
        'email',
    ];

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
