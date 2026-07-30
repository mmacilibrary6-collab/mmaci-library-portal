<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\DatabaseMedia;
use App\Support\MediaStorage;

class ThesisProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'sort_order',
        'status',
        'is_active',
        'icon',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'status'     => 'boolean',
    ];

    /**
     * Get the thesis/dissertation folders belonging to this program.
     */
    public function folders(): HasMany
    {
        return $this->hasMany(
            ThesisFolder::class,
            'thesis_program_id'
        );
    }

    /**
     * Get the public URL of the program image.
     */
    public function getImageUrlAttribute(): string
    {
        if (blank($this->image)) {
            return asset('images/readingarea.jpg');
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            MediaStorage::url($this->image, asset('images/readingarea.jpg'))
        );
    }
}
