<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\ImageUrl;
use App\Support\DatabaseMedia;
use App\Support\MediaStorage;

class NewArrival extends Model
{
    use HasFactory;

    protected $fillable = [
        'accession_number',
        'title',
        'author',
        'isbn',
        'category',
        'publication_year',
        'publisher',
        'description',
        'cover_image',
        'file_url',
        'access_url',
        'availability_status',
        'arrival_date',
        'is_featured',
        'image',
    ];

    protected $casts = [
        'arrival_date' => 'date',
    ];

    public function getDisplayAuthorAttribute(): string
    {
        return filled($this->author)
            ? $this->author
            : 'No author';
    }

    public function getFormattedArrivalDateAttribute(): string
    {
        return $this->arrival_date
            ? $this->arrival_date->format('F d, Y')
            : 'Date not specified';
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
            return route('database.media', [
                'type' => 'new-arrival',
                'id' => $this->getKey(),
                'v' => $this->updated_at?->timestamp,
            ]);
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            ImageUrl::resolve($this->image, 'images/image-fallback.svg')
        );
    }
}
