<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodicalFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodical_program_id',
        'title',
        'description',
        'folder_link',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'periodical_program_id' => 'integer',
        'sort_order' => 'integer',
        'status' => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(PeriodicalProgram::class, 'periodical_program_id');
    }
}
