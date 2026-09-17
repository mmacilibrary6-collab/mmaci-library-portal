<?php

namespace App\Support;

use App\Models\EbookFolder;
use App\Models\ThesisFolder;
use App\Models\PeriodicalFolder;
use Illuminate\Database\Eloquent\Builder;

class FolderQuery
{
    public const COLLECTIONS = [
        'ebooks' => [EbookFolder::class, 'ebook_program_id', 'drive_link', 'E-Book Folders'],
        'theses' => [ThesisFolder::class, 'thesis_program_id', 'drive_link', 'Thesis & Dissertation Folders'],
        'periodicals' => [PeriodicalFolder::class, 'periodical_program_id', 'folder_link', 'Periodical Folders'],
    ];

    public static function build(string $collection, string $search = '', array $programs = [], array $categories = []): Builder
    {
        [$model, $programColumn, $linkColumn] = self::COLLECTIONS[$collection];

        return $model::query()->with('program')
            ->when(trim($search) !== '', function ($query) use ($search, $linkColumn, $collection) {
                $search = '%'.trim($search).'%';
                $query->where(function ($query) use ($search, $linkColumn, $collection) {
                    $query->where('title', 'like', $search)
                        ->orWhere('description', 'like', $search)
                        ->orWhere($linkColumn, 'like', $search)
                        ->orWhereHas('program', fn ($program) => $program->where('title', 'like', $search));
                    if ($collection === 'periodicals') {
                        $query->orWhere('accession_number', 'like', $search);
                    }
                });
            })
            ->when($programs !== [], fn ($query) => $query->whereIn($programColumn, $programs))
            ->when($collection === 'periodicals' && $categories !== [], fn ($query) => $query->whereIn('category', $categories))
            ->orderBy('title')->orderBy('id');
    }
}
