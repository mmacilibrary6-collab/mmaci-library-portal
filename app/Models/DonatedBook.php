<?php

namespace App\Models;

use App\Support\DatabaseMedia;
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
            return asset('images/readingarea.jpg');
        }

        if ($this->exists && !str_starts_with((string) $this->image, 'http')) {
            return route('database.media', ['type' => 'donated-book', 'id' => $this->getKey(), 'v' => $this->updated_at?->timestamp]);
        }

        return DatabaseMedia::toDataUri(
            $this->image,
            MediaStorage::url($this->image, asset('images/readingarea.jpg'))
        );
    }
}
