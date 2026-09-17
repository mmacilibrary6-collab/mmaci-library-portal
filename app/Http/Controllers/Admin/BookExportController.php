<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonatedBook;
use App\Models\NewArrival;
use App\Support\XlsxExport;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookExportController extends Controller
{
    public function __invoke(Request $request, string $collection): BinaryFileResponse
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'availability_status' => ['nullable', 'in:available,unavailable'],
        ]);
        $arrivals = $collection === 'new-arrivals';
        $columns = $arrivals
            ? ['accession_number', 'title', 'author', 'isbn', 'category', 'publication_year', 'publisher', 'description', 'availability_status', 'arrival_date']
            : ['title', 'description', 'status'];
        $headers = $arrivals
            ? ['Accession Number', 'Title', 'Author', 'ISBN', 'Category', 'Publication Year', 'Publisher', 'Description', 'Availability', 'Arrival Date']
            : ['Title', 'Description', 'Status'];
        $query = $arrivals ? NewArrival::query() : DonatedBook::query();
        $query->select($columns);
        $search = trim($filters['search'] ?? '');
        if ($search !== '') {
            $searchColumns = $arrivals ? ['accession_number', 'title', 'author', 'category', 'description'] : ['title', 'description'];
            $query->where(function ($query) use ($searchColumns, $search) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%'.$search.'%');
                }
            });
        }
        if ($arrivals) {
            $query->when(filled($filters['availability_status'] ?? null), fn ($query) => $query->where('availability_status', $filters['availability_status']))
                ->orderByDesc('arrival_date')->orderByDesc('created_at');
        } else {
            $query->orderBy('sort_order')->orderBy('title');
        }
        $query->orderBy('id');
        $rows = (function () use ($query, $columns) {
            foreach ($query->lazy(500) as $book) {
                yield array_map(fn ($column) => match ($column) {
                    'arrival_date' => $book->arrival_date?->format('Y-m-d'),
                    'availability_status' => ucfirst($book->availability_status),
                    'status' => $book->status ? 'Active' : 'Inactive',
                    default => $book->{$column},
                }, $columns);
            }
        })();
        $path = (new XlsxExport)->create($headers, $rows, $arrivals ? 'New Arrivals' : 'Donated Books');

        return response()->download($path, $collection.'-'.now()->format('Y-m-d-His').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'private, no-store',
        ])->deleteFileAfterSend(true);
    }
}
