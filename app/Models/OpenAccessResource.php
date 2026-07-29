<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OpenAccessResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'website_url',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('title');
    }

    public function getImageUrlAttribute(): string
    {
        if (blank($this->image)) {
            return asset('images/default-resource.png');
        }

        $image = trim($this->image);

        if (
            str_starts_with($image, 'http://') ||
            str_starts_with($image, 'https://')
        ) {
            return $image;
        }

        $image = str_starts_with($image, 'storage/')
            ? substr($image, 8)
            : $image;

        $image = ltrim($image, '/');

        return Storage::disk('public')->exists($image)
            ? route('public.media', ['path' => $image])
            : asset('images/default-resource.png');
    }
}
