<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\ImageUrl;
use App\Support\DatabaseMedia;
use App\Support\MediaStorage;

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
            return route('database.media', ['type' => 'gallery-image', 'id' => $this->getKey(), 'v' => $this->updated_at?->timestamp]);
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            ImageUrl::resolve($this->image, 'images/image-fallback.svg')
        );
    }
}
