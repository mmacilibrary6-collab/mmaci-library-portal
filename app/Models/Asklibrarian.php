<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AskLibrarian extends Model
{
    use HasFactory;

    /**
     * The database table associated with the model.
     */
    protected $table = 'ask_librarians';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'question',
        'response',
        'status',
    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Scope: Pending inquiries.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Answered inquiries.
     */
    public function scopeAnswered($query)
    {
        return $query->where('status', 'answered');
    }

    /**
     * Check if the inquiry has been answered.
     */
    public function isAnswered()
    {
        return $this->status === 'answered';
    }

    /**
     * Check if the inquiry is still pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
}