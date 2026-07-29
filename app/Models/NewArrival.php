<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewArrival extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'resource_type',
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
