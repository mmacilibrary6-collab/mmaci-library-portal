<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbookFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'ebook_program_id',
        'title',
        'description',
        'drive_link',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'ebook_program_id' => 'integer',
        'sort_order'       => 'integer',
        'status'           => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(
            EbookProgram::class,
            'ebook_program_id'
        );
    }
}