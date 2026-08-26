<?php

namespace App\Models;

use App\Support\DatabaseMedia;
use App\Support\ImageUrl;
use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonatedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'status' => 'boolean',
    ];

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
            return route('database.media', ['type' => 'donated-book', 'id' => $this->getKey(), 'v' => $this->updated_at?->timestamp]);
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            ImageUrl::resolve($this->image, 'images/image-fallback.svg')
        );
    }
}
