<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodicalFolder extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'newspaper' => ['label' => 'Newspapers', 'description' => 'Provides current news and information about local, national, and international events.'],
        'magazine' => ['label' => 'Magazines', 'description' => 'Offers publications containing articles, stories, pictures, and information about different topics and interests.'],
        'journal' => ['label' => 'Journals', 'description' => 'Provides scholarly and academic articles useful for learning, research, and professional studies.'],
        'e_journal' => ['label' => 'E-Journals', 'description' => 'Provides online access to academic and scholarly journal articles through digital platforms.'],
        'e_newspaper' => ['label' => 'E-Newspapers', 'description' => 'Provides online access to current and archived newspapers in digital format.'],
        'new_arrival' => ['label' => 'New Arrivals', 'description' => 'Displays newly acquired newspapers, magazines, journals, and other periodical materials for users to discover.'],
    ];

    public static function requiresAccession(string $category): bool
    {
        return in_array($category, ['journal', 'newspaper', 'journal_newspaper'], true);
    }

    protected $fillable = [
        'periodical_program_id',
        'category',
        'accession_number',
        'title',
        'description',
        'folder_link',
        'status',
    ];

    protected $casts = [
        'periodical_program_id' => 'integer',
        'status' => 'boolean',
    ];

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category]['label'] ?? 'Periodical';
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(PeriodicalProgram::class, 'periodical_program_id');
    }
}
