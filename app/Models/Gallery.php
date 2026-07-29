<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Support\DatabaseMedia;
use App\Support\MediaStorage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'sort_order',
        'is_active',
        'event_date',
        'location',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->latest('created_at');
    }

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->latest('created_at');
    }

    public function getImageUrlAttribute(): string
    {
        if (blank($this->image)) {
            return asset('images/readingarea.jpg');
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            MediaStorage::url($this->image, asset('images/readingarea.jpg'))
        );
    }

    public function getCoverImageUrlAttribute(): string
    {
        return $this->images->isNotEmpty()
            ? $this->images->sortByDesc('created_at')->first()->image_url
            : $this->image_url;
    }
}
