<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\MediaStorage;

class EbookProgram extends Model
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
     * Get the e-book folders belonging to this program.
     */
    public function folders(): HasMany
    {
        return $this->hasMany(
            EbookFolder::class,
            'ebook_program_id'
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

        if (str_starts_with($this->image, 'data:')) {
            return $this->image;
        }

        return MediaStorage::exists($this->image)
            ? MediaStorage::url($this->image, asset('images/readingarea.jpg'))
            : asset('images/readingarea.jpg');
    }
}
