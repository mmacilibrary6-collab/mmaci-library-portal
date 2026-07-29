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
        'contact_number',
        'subject',
        'message',
        'reply',
        'replied_at',
        'status',
    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
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
        return $query->whereIn('status', ['replied', 'read']);
    }

    /**
     * Check if the inquiry has been answered.
     */
    public function isAnswered()
    {
        return in_array($this->status, ['replied', 'read'], true);
    }

    /**
     * Check if the inquiry is still pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Backward-compatible aliases for older view code.
     */
    public function getQuestionAttribute(): ?string
    {
        return $this->subject;
    }

    public function getResponseAttribute(): ?string
    {
        return $this->reply;
    }
}
