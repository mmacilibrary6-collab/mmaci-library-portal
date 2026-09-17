<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodicalFolder;
use App\Support\FolderQuery;
use App\Support\XlsxExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FolderExportController extends Controller
{
    public function __invoke(Request $request, string $collection): BinaryFileResponse
    {
        abort_unless(isset(FolderQuery::COLLECTIONS[$collection]), 404);
        $programTable = ['ebooks' => 'ebook_programs', 'theses' => 'thesis_programs', 'periodicals' => 'periodical_programs'][$collection];
        $filters = $request->validate([
            'programs' => ['sometimes', 'array'],
            'programs.*' => ['integer', 'distinct', Rule::exists($programTable, 'id')],
            'categories' => [$collection === 'periodicals' ? 'sometimes' : 'prohibited', 'array'],
            'categories.*' => ['string', 'distinct', Rule::in(array_keys(PeriodicalFolder::CATEGORIES))],
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $query = FolderQuery::build($collection, $filters['search'] ?? '', $filters['programs'] ?? [], $filters['categories'] ?? []);
        $headers = ['Folder Title', 'Program'];
        if ($collection === 'periodicals') {
            $headers = [...$headers, 'Category', 'Accession Number'];
        }
        $headers = [...$headers, 'Description', 'Folder Link', 'Status', 'Created At', 'Updated At'];

        $rows = (function () use ($query, $collection) {
            foreach ($query->lazy(500) as $folder) {
                $row = [$folder->title, $folder->program?->title ?? 'Unassigned'];
                if ($collection === 'periodicals') {
                    $row = [...$row, $folder->categoryLabel(), $folder->accession_number];
                }
                yield [...$row, $folder->description, $folder->drive_link ?? $folder->folder_link,
                    $folder->status ? 'Active' : 'Inactive', $folder->created_at?->format('Y-m-d H:i:s'), $folder->updated_at?->format('Y-m-d H:i:s')];
            }
        })();

        $path = (new XlsxExport)->create($headers, $rows);

        return response()->download($path, $collection.'-folders-'.now()->format('Y-m-d-His').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'private, no-store',
        ])->deleteFileAfterSend(true);
    }
}
