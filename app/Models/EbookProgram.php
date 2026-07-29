<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $image = trim($this->image);

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        $image = Str::startsWith($image, 'storage/')
            ? Str::after($image, 'storage/')
            : $image;

        $image = ltrim($image, '/');

        return Storage::disk('public')->exists($image)
            ? Storage::disk('public')->url($image)
            : asset('images/readingarea.jpg');
    }
}
