<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (blank($this->image)) {
            return asset('images/readingarea.jpg');
        }

        $image = trim($this->image);
        $image = str_replace('\\', '/', $image);

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        $image = Str::startsWith($image, 'storage/')
            ? Str::after($image, 'storage/')
            : $image;

        $image = ltrim(str_replace('\\', '/', $image), '/');

        return Storage::disk('public')->exists($image)
            ? route('public.media', ['path' => $image])
            : asset('images/readingarea.jpg');
    }
}
