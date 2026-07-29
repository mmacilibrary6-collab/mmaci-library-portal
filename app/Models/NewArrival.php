<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewArrival extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category',
        'description',
        'resource_type',
        'availability_status',
        'arrival_date',
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

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset(
            'storage/' . ltrim($this->image, '/')
        );
    }
}