<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Borrowing;
use App\Support\XlsxExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BorrowingExportController extends Controller
{
    public function __invoke(Request $request): BinaryFileResponse
    {
        $filters = $request->validate([
            'list' => ['required', Rule::in(['borrowings', 'borrowers'])],
            'status' => ['nullable', Rule::in(['pending', 'approved', 'borrowed', 'overdue', 'returned', 'rejected'])],
            'borrower_type' => ['nullable', Rule::in(['student', 'faculty', 'other'])],
            'search' => ['nullable', 'string', 'max:255'],
        ]);
        $query = Borrowing::query();
        $status = $filters['status'] ?? null;
        if ($status === 'overdue') {
            $query->where(function ($query) {
                $query->where('status', 'overdue')->orWhere(function ($query) {
                    $query->where('status', 'borrowed')->whereNull('date_returned')->whereDate('due_date', '<', today());
                });
            });
        } elseif ($status === 'borrowed') {
            $query->where('status', 'borrowed')->where(function ($query) {
                $query->whereNotNull('date_returned')->orWhereNull('due_date')->orWhereDate('due_date', '>=', today());
            });
        } elseif ($status) {
            $query->where('status', $status);
        }
        if (filled($filters['borrower_type'] ?? null)) {
            $query->whereHas('borrower', fn ($borrower) => $borrower->where('borrower_type', $filters['borrower_type']));
        }
        if (filled($filters['search'] ?? null)) {
            $search = '%'.trim($filters['search']).'%';
            $query->where(function ($query) use ($search) {
                $query->where('accession_number', 'like', $search)->orWhere('bibliographical_description', 'like', $search)
                    ->orWhereHas('borrower', function ($borrower) use ($search) {
                        $borrower->where('name', 'like', $search)->orWhere('id_number', 'like', $search)->orWhere('department', 'like', $search);
                    });
            });
        }

        $headers = ['Borrower Name', 'ID Number', 'Borrower Type', 'Department', 'Semester', 'Contact Number', 'Email'];
        $borrowersOnly = $filters['list'] === 'borrowers';
        if (! $borrowersOnly) {
            $headers = [...$headers, 'Record ID', 'Book Title / Details', 'Accession Number', 'Status', 'Date Borrowed', 'Due Date', 'Date Returned', 'Received By', 'Released By', 'Returned By', 'Remarks'];
        }
        $records = $borrowersOnly
            ? Borrower::whereIn('id', $query->select('borrower_id'))->orderBy('name')->orderBy('id')
            : $query->with('borrower')->orderByDesc('id');
        $rows = (function () use ($records, $borrowersOnly) {
            foreach ($records->lazy(500) as $record) {
                $borrower = $borrowersOnly ? $record : $record->borrower;
                $row = [$borrower?->name, $borrower?->id_number, $borrower?->borrower_type_label, $borrower?->department, $borrower?->semester, $borrower?->contact_number, $borrower?->email];
                yield $borrowersOnly ? $row : [...$row, $record->id, $record->bibliographical_description, $record->accession_number, ucfirst($record->display_status), $record->date_borrowed?->format('Y-m-d'), $record->due_date?->format('Y-m-d'), $record->date_returned?->format('Y-m-d'), $record->received_by, $record->released_by, $record->returned_by, $record->remarks];
            }
        })();
        $path = (new XlsxExport)->create($headers, $rows, $borrowersOnly ? 'Borrowers' : 'Borrowings');
        return response()->download($path, $filters['list'].'-'.($status ?: 'all').'-'.now()->format('Y-m-d-His').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'private, no-store',
        ])->deleteFileAfterSend(true);
    }
}
