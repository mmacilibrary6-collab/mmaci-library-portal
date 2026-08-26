<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\ImageUrl;
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
            return ImageUrl::fallback('images/image-fallback.svg');
        }

        if (
            str_starts_with((string) $this->image, 'http://') ||
            str_starts_with((string) $this->image, 'https://') ||
            str_starts_with((string) $this->image, 'data:')
        ) {
            return (string) $this->image;
        }

        if ($this->exists) {
            return route('database.media', ['type' => 'thesis-program', 'id' => $this->getKey(), 'v' => $this->updated_at?->timestamp]);
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            ImageUrl::resolve($this->image, 'images/image-fallback.svg')
        );
    }
}
