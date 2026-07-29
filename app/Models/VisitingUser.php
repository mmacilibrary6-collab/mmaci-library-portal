<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitingUser extends Model
{
    use HasFactory;

    /**
     * The database table associated with the model.
     */
    protected $table = 'visiting_users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'school',
        'purpose',
        'contact_number',
        'email',
        'visit_date',
        'status',
        'remarks',
    ];

    /**
     * Default values.
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * Scope: Pending visitors.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Approved visitors.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Rejected visitors.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Determine if the visitor is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Determine if the visitor is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Determine if the visitor is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
