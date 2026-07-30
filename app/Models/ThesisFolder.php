<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThesisFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_program_id',
        'title',
        'description',
        'drive_link',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'thesis_program_id' => 'integer',
        'sort_order'       => 'integer',
        'status'           => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(
            ThesisProgram::class,
            'thesis_program_id'
        );
    }
}