<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Borrowing;
use App\Models\NewArrival;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(Request $request): View
    {
        $this->refreshOverdueBorrowings();

        $search = trim((string) $request->input('search'));
        $status = $request->input('status');
        $dateBorrowed = $request->input('date_borrowed');
        $dueDate = $request->input('due_date');

        $borrowings = Borrowing::query()
            ->with(['borrower', 'book'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('accession_number', 'like', "%{$search}%")
                        ->orWhere('bibliographical_description', 'like', "%{$search}%")
                        ->orWhereHas('borrower', function ($borrowerQuery) use ($search) {
                            $borrowerQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('id_number', 'like', "%{$search}%")
                                ->orWhere('department', 'like', "%{$search}%");
                        });
                });
            })
            ->when(filled($status), fn ($query) => $query->where('status', $status))
            ->when(filled($dateBorrowed), fn ($query) => $query->whereDate('date_borrowed', $dateBorrowed))
            ->when(filled($dueDate), fn ($query) => $query->whereDate('due_date', $dueDate))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'borrowed' => Borrowing::whereIn('status', [Borrowing::STATUS_BORROWED, Borrowing::STATUS_OVERDUE])->whereNull('date_returned')->count(),
            'pending' => Borrowing::where('status', Borrowing::STATUS_PENDING)->count(),
            'overdue' => Borrowing::where('status', Borrowing::STATUS_OVERDUE)->count(),
            'returned' => Borrowing::where('status', Borrowing::STATUS_RETURNED)->count(),
        ];

        return view('admin.borrowings.index', compact('borrowings', 'stats'));
    }

    public function show(Borrowing $borrowing): View
    {
        $borrowing->load(['borrower.borrowings.book', 'book']);
        $borrowing->markOverdueIfNeeded();

        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function edit(Borrowing $borrowing): View
    {
        $books = NewArrival::query()
            ->whereNotNull('accession_number')
            ->orderBy('title')
            ->get();

        return view('admin.borrowings.edit', compact('borrowing', 'books'));
    }

    public function update(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $validated = $this->validateBorrowing($request, $borrowing);
        $book = NewArrival::where('accession_number', $validated['accession_number'])->firstOrFail();

        if ($this->bookHasAnotherActiveLoan($book->accession_number, $borrowing)) {
            return back()
                ->withInput()
                ->withErrors(['accession_number' => 'This book already has another active borrowing transaction.']);
        }

        DB::transaction(function () use ($validated, $borrowing, $book): void {
            $borrower = $borrowing->borrower;
            $borrower->update([
                'name' => trim($validated['name']),
                'id_number' => trim($validated['id_number']),
                'contact_number' => filled($validated['contact_number'] ?? null) ? trim($validated['contact_number']) : null,
                'department' => trim($validated['department']),
                'semester' => filled($validated['semester'] ?? null) ? trim($validated['semester']) : null,
                'email' => filled($validated['email'] ?? null) ? trim($validated['email']) : null,
            ]);

            $oldBookId = $borrowing->new_arrival_id;

            $borrowing->update([
                'new_arrival_id' => $book->id,
                'accession_number' => $book->accession_number,
                'bibliographical_description' => $validated['bibliographical_description'],
                'date_borrowed' => $validated['date_borrowed'],
                'due_date' => $validated['due_date'],
                'date_returned' => $validated['date_returned'] ?? null,
                'status' => $validated['status'],
                'received_by' => filled($validated['received_by'] ?? null) ? trim($validated['received_by']) : null,
                'returned_by' => filled($validated['returned_by'] ?? null) ? trim($validated['returned_by']) : null,
                'remarks' => filled($validated['remarks'] ?? null) ? trim($validated['remarks']) : null,
            ]);

            $this->syncBookAvailability($borrowing, $oldBookId);
        });

        return redirect()
            ->route('admin.borrowings.show', $borrowing)
            ->with('success', 'Borrowing record updated successfully.');
    }

    public function approve(Borrowing $borrowing): RedirectResponse
    {
        return $this->setStatus($borrowing, Borrowing::STATUS_APPROVED, 'Borrowing request approved.');
    }

    public function markBorrowed(Borrowing $borrowing): RedirectResponse
    {
        if ($this->bookHasAnotherActiveLoan($borrowing->accession_number, $borrowing)) {
            return back()->with('error', 'This book already has another active borrowing transaction.');
        }

        return $this->setStatus($borrowing, Borrowing::STATUS_BORROWED, 'Book marked as borrowed.');
    }

    public function markReturned(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $validated = $request->validate([
            'returned_by' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($borrowing, $validated): void {
            $borrowing->update([
                'status' => Borrowing::STATUS_RETURNED,
                'date_returned' => now()->toDateString(),
                'returned_by' => filled($validated['returned_by'] ?? null) ? trim($validated['returned_by']) : auth()->user()?->name,
                'remarks' => filled($validated['remarks'] ?? null) ? trim($validated['remarks']) : $borrowing->remarks,
                'returned_processed_by' => auth()->id(),
            ]);

            $borrowing->book?->update(['availability_status' => 'available']);
        });

        return back()->with('success', 'Book marked as returned.');
    }

    public function reject(Borrowing $borrowing): RedirectResponse
    {
        return $this->setStatus($borrowing, Borrowing::STATUS_REJECTED, 'Borrowing request rejected.');
    }

    public function destroy(Borrowing $borrowing): RedirectResponse
    {
        $book = $borrowing->book;
        $borrowing->delete();

        if ($book && ! Borrowing::activeForBook((string) $book->accession_number)->exists()) {
            $book->update(['availability_status' => 'available']);
        }

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Erroneous borrowing record deleted.');
    }

    public function borrower(Borrower $borrower): View
    {
        $borrower->load(['borrowings' => fn ($query) => $query->with('book')->latest()]);

        return view('admin.borrowings.borrower', compact('borrower'));
    }

    public function printCard(Borrower $borrower): View
    {
        $borrower->load(['borrowings' => fn ($query) => $query->with('book')->orderBy('date_borrowed')]);

        return view('admin.borrowings.print-card', compact('borrower'));
    }

    private function setStatus(Borrowing $borrowing, string $status, string $message): RedirectResponse
    {
        if (
            in_array($status, [Borrowing::STATUS_APPROVED, Borrowing::STATUS_BORROWED], true) &&
            $this->bookHasAnotherActiveLoan($borrowing->accession_number, $borrowing)
        ) {
            return back()->with('error', 'This book already has another active borrowing transaction.');
        }

        DB::transaction(function () use ($borrowing, $status): void {
            $borrowing->update([
                'status' => $status,
                'approved_by' => in_array($status, [Borrowing::STATUS_APPROVED, Borrowing::STATUS_BORROWED], true)
                    ? auth()->id()
                    : $borrowing->approved_by,
            ]);

            if ($status === Borrowing::STATUS_BORROWED) {
                $borrowing->book?->update(['availability_status' => 'borrowed']);
            }

            if ($status === Borrowing::STATUS_REJECTED) {
                $borrowing->book?->update(['availability_status' => 'available']);
            }
        });

        return back()->with('success', $message);
    }

    private function validateBorrowing(Request $request, Borrowing $borrowing): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:100', Rule::unique('borrowers', 'id_number')->ignore($borrowing->borrower_id)],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:150'],
            'semester' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'accession_number' => ['required', 'string', 'max:100', Rule::exists('new_arrivals', 'accession_number')],
            'bibliographical_description' => ['required', 'string'],
            'date_borrowed' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:date_borrowed'],
            'date_returned' => ['nullable', 'date', 'after_or_equal:date_borrowed'],
            'status' => ['required', Rule::in([
                Borrowing::STATUS_PENDING,
                Borrowing::STATUS_APPROVED,
                Borrowing::STATUS_BORROWED,
                Borrowing::STATUS_RETURNED,
                Borrowing::STATUS_OVERDUE,
                Borrowing::STATUS_REJECTED,
            ])],
            'received_by' => ['nullable', 'string', 'max:255'],
            'returned_by' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    private function bookHasAnotherActiveLoan(string $accessionNumber, Borrowing $borrowing): bool
    {
        return Borrowing::activeForBook($accessionNumber)
            ->whereKeyNot($borrowing->id)
            ->exists();
    }

    private function syncBookAvailability(Borrowing $borrowing, ?int $oldBookId = null): void
    {
        if ($oldBookId && $oldBookId !== $borrowing->new_arrival_id) {
            $oldBook = NewArrival::find($oldBookId);
            if ($oldBook && ! Borrowing::activeForBook((string) $oldBook->accession_number)->exists()) {
                $oldBook->update(['availability_status' => 'available']);
            }
        }

        if (in_array($borrowing->status, [Borrowing::STATUS_BORROWED, Borrowing::STATUS_OVERDUE], true)) {
            $borrowing->book?->update(['availability_status' => 'borrowed']);
        }

        if (in_array($borrowing->status, [Borrowing::STATUS_RETURNED, Borrowing::STATUS_REJECTED], true)) {
            $borrowing->book?->update(['availability_status' => 'available']);
        }
    }

    private function refreshOverdueBorrowings(): void
    {
        Borrowing::query()
            ->whereIn('status', [Borrowing::STATUS_APPROVED, Borrowing::STATUS_BORROWED])
            ->whereNull('date_returned')
            ->whereDate('due_date', '<', now()->toDateString())
            ->update(['status' => Borrowing::STATUS_OVERDUE]);
    }
}
