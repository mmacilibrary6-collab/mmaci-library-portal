<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Borrowing;
use App\Services\BorrowingPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DeletedBorrowingController extends Controller
{
    public function index()
    {
        $records = Borrowing::onlyTrashed()->with(['borrower', 'deletedBy'])->orderByDesc('deleted_at')->paginate(20);
        return view('admin.borrowings.deleted', compact('records'));
    }

    public function restore(int $id)
    {
        DB::transaction(function () use ($id) {
            $record = Borrowing::onlyTrashed()->findOrFail($id);
            $borrower = Borrower::whereKey($record->borrower_id)->lockForUpdate()->firstOrFail();
            $record = Borrowing::onlyTrashed()->whereKey($id)->lockForUpdate()->firstOrFail();
            if (in_array($record->status, ['pending', 'approved', 'borrowed', 'overdue'], true)) {
                $duplicate = $borrower->borrowings()->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue'])->get()->contains(fn ($loan) => mb_strtolower(\Illuminate\Support\Str::squish($loan->bibliographical_description)) === mb_strtolower(\Illuminate\Support\Str::squish($record->bibliographical_description)));
                if ($duplicate) {
                    throw ValidationException::withMessages(['restore' => 'This borrower already has an active request for this title. Resolve it before restoring.']);
                }
            }
            if (in_array($record->status, ['approved', 'borrowed', 'overdue'], true)) {
                $record->book()->lockForUpdate()->first();
                if (filled($record->accession_number) && Borrowing::activeForBook($record->accession_number)->exists()) {
                    throw ValidationException::withMessages(['restore' => 'This book copy is already assigned to another active loan. It cannot be restored yet.']);
                }
                BorrowingPolicy::assertCapacity($borrower);
            }
            $record->restore();
            $record->forceFill(['deleted_by' => null])->save();
            $record->markOverdueIfNeeded();
            if (in_array($record->status, ['borrowed', 'overdue'], true)) {
                $record->book?->update(['availability_status' => 'borrowed']);
            }
        }, 3);
        return back()->with('success', 'Record restored with its original reference.');
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'scope' => ['required', 'in:selected,all'],
            'ids' => ['required_if:scope,selected', 'array', 'max:100'],
            'ids.*' => ['integer', 'distinct'],
            'before_id' => ['required_if:scope,all', 'integer', 'min:1'],
        ]);
        $count = DB::transaction(function () use ($data) {
            $query = Borrowing::onlyTrashed();
            if ($data['scope'] === 'selected') {
                $query->whereIn('id', $data['ids']);
            } else {
                $query->where('id', '<=', $data['before_id']);
            }
            $records = $query->lockForUpdate()->get();
            if ($records->isEmpty()) {
                throw ValidationException::withMessages(['ids' => 'No deleted records matched. Refresh the page and select records again.']);
            }
            foreach ($records as $record) $record->forceDelete();
            return $records->count();
        }, 3);
        return back()->with('success', "Permanently deleted {$count} record(s).");
    }
}
