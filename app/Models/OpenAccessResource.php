<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\MediaStorage;

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

        return MediaStorage::exists($this->image)
            ? MediaStorage::url($this->image, asset('images/default-resource.png'))
            : asset('images/default-resource.png');
    }
}
