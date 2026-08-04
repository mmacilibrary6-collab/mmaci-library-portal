<?php

namespace App\Models;

use App\Support\DatabaseMedia;
use App\Support\MediaStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodicalProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
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

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'journal_newspaper' => 'Journal & Newspaper Clippings',
            'magazine' => 'Magazines',
            default => $this->title ?: 'Periodical',
        };
    }

    public function folders(): HasMany
    {
        return $this->hasMany(PeriodicalFolder::class, 'periodical_program_id');
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
}
