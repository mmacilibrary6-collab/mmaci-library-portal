<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\DatabaseMedia;
use App\Support\MediaStorage;

class OpenAccessResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'website_url',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('title', 'asc');
    }

    public function getImageUrlAttribute(): string
    {
        if (blank($this->image)) {
            return asset('images/default-resource.png');
        }

        if ($this->exists && !str_starts_with((string) $this->image, 'http')) {
            return route('database.media', ['type' => 'open-access-resource', 'id' => $this->getKey(), 'v' => $this->updated_at?->timestamp]);
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            MediaStorage::url($this->image, asset('images/default-resource.png'))
        );
    }
}
