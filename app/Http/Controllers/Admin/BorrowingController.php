<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Borrowing;
use App\Models\NewArrival;
use App\Services\BorrowingEmails;
use App\Services\BorrowingPolicy;
use Illuminate\Validation\ValidationException;
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
        $borrowerType = $request->input('borrower_type');
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
            ->when(filled($borrowerType), function ($query) use ($borrowerType) {
                $query->whereHas('borrower', function ($borrowerQuery) use ($borrowerType) {
                    $borrowerQuery->where('borrower_type', $borrowerType);
                });
            })
            ->when(filled($status), fn ($query) => $query->where('status', $status))
            ->when(filled($dateBorrowed), fn ($query) => $query->whereDate('date_borrowed', $dateBorrowed))
            ->when(filled($dueDate), fn ($query) => $query->whereDate('due_date', $dueDate))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'borrowed' => Borrowing::whereIn('status', [
                Borrowing::STATUS_BORROWED,
                Borrowing::STATUS_OVERDUE,
            ])->whereNull('date_returned')->count(),

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
        $borrowing->load(['borrower', 'book']);

        return view('admin.borrowings.edit', compact('borrowing'));
    }

    public function update(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $validated = $this->validateBorrowing($request, $borrowing);

        $dateError = $this->borrowingDateError($validated);

        if ($dateError !== null) {
            return back()
                ->withInput()
                ->withErrors($dateError);
        }

        if (in_array($validated['status'], ['approved', 'borrowed', 'overdue'], true) && $this->bookHasAnotherActiveLoan($validated['accession_number'], $borrowing)) {
            return back()
                ->withInput()
                ->withErrors([
                    'accession_number' => 'This book already has another active borrowing transaction.',
                ]);
        }

        DB::transaction(function () use ($validated, $borrowing): void {
            $borrower = Borrower::whereKey($borrowing->borrower_id)->lockForUpdate()->first();
            $borrowing = Borrowing::whereKey($borrowing->id)->lockForUpdate()->firstOrFail();

            if (! $borrower) {
                abort(422, 'This borrowing record has no borrower attached.');
            }

            if ($validated['status'] !== $borrowing->status) {
                throw ValidationException::withMessages(['status' => 'This record changed. Reload it before editing.']);
            }
            if ($validated['borrower_type'] !== $borrower->borrower_type && $borrower->borrowings()->whereIn('status', ['borrowed', 'overdue'])->whereNull('date_returned')->exists()) {
                throw ValidationException::withMessages(['borrower_type' => 'Return active loans before changing the borrower type.']);
            }
            if (in_array($borrowing->status, ['borrowed', 'overdue'], true)) {
                foreach (['date_borrowed', 'due_date'] as $field) {
                    if (\Illuminate\Support\Carbon::parse($validated[$field])->toDateString() !== $borrowing->{$field}?->toDateString()) {
                        throw ValidationException::withMessages([$field => 'Loan dates are locked after release. Use Renew Book to extend the due date.']);
                    }
                }
            } elseif (in_array($borrowing->status, ['pending', 'approved'], true) && filled($validated['date_borrowed'] ?? null) && filled($validated['due_date'] ?? null)) {
                BorrowingPolicy::assertDates($validated['borrower_type'], $validated['date_borrowed'], $validated['due_date']);
            }

            $borrower->update([
                'name' => trim($validated['name']),
                'id_number' => trim($validated['id_number']),
                'borrower_type' => $validated['borrower_type'],
                'borrower_type_other' => $validated['borrower_type'] === 'other' ? trim($validated['borrower_type_other']) : null,
                'contact_number' => filled($validated['contact_number'] ?? null)
                    ? trim($validated['contact_number'])
                    : null,
                'department' => trim($validated['department']),
                'semester' => $validated['semester'],
                'email' => filled($validated['email'] ?? null)
                    ? trim($validated['email'])
                    : null,
            ]);

            $oldBookId = $borrowing->new_arrival_id;

            /*
             * Keep the borrowing linked to New Arrivals when the accession
             * number exists there. Do not force new_arrival_id to null.
             */
            $book = NewArrival::query()
                ->whereNotNull('accession_number')
                ->where('accession_number', trim($validated['accession_number'] ?? ''))
                ->first();

            $borrowing->update([
                'new_arrival_id' => $book?->id,
                'accession_number' => filled($validated['accession_number'] ?? null) ? trim($validated['accession_number']) : null,
                'bibliographical_description' => trim($validated['bibliographical_description']),
                'date_borrowed' => $validated['date_borrowed'] ?? null,
                'due_date' => $validated['due_date'] ?? null,
                'date_returned' => $validated['date_returned'] ?? null,
                'status' => $validated['status'],
                'received_by' => in_array($borrowing->status, ['borrowed', 'overdue', 'returned'], true)
                    ? $borrower->name
                    : null,
                'returned_by' => filled($validated['returned_by'] ?? null)
                    ? trim($validated['returned_by'])
                    : null,
                'remarks' => filled($validated['remarks'] ?? null)
                    ? trim($validated['remarks'])
                    : null,
                'released_by' => filled($validated['released_by'] ?? null)
                    ? trim($validated['released_by'])
                    : null,
            ]);

            $borrowing->refresh()->load('book');
            $borrowing->markOverdueIfNeeded();

            $this->syncBookAvailability($borrowing, $oldBookId);
        });

        return redirect()
            ->route('admin.borrowings.show', $borrowing)
            ->with('success', 'Borrowing record updated successfully.');
    }

    public function approve(Borrowing $borrowing): RedirectResponse
    {
        return $this->setStatus(
            $borrowing,
            Borrowing::STATUS_APPROVED,
            'Borrowing request approved.'
        );
    }

    public function markBorrowed(Request $request, Borrowing $borrowing): RedirectResponse
    {
        if (blank($borrowing->accession_number)) {
            return back()->with('error', 'Assign an accession number using Edit Record before releasing the book.');
        }

        if ($borrowing->status !== Borrowing::STATUS_APPROVED) {
            return back()->with('error', 'Approve this request before releasing the book.');
        }

        $validated = $request->validate([
            'date_borrowed' => ['required', 'date', 'before_or_equal:today'],
            'due_date' => ['required', 'date', 'after_or_equal:date_borrowed'],
            'released_by' => ['required', 'string', 'max:255'],
        ]);

        if ($this->bookHasAnotherActiveLoan($borrowing->accession_number, $borrowing)) {
            return back()->with(
                'error',
                'This book already has another active borrowing transaction.'
            );
        }

        DB::transaction(function () use ($borrowing, $validated): void {
            $borrower = Borrower::whereKey($borrowing->borrower_id)->lockForUpdate()->firstOrFail();
            $borrowing = Borrowing::whereKey($borrowing->id)->lockForUpdate()->firstOrFail();
            if ($borrowing->status !== Borrowing::STATUS_APPROVED) {
                throw ValidationException::withMessages(['status' => 'This request is no longer awaiting release. Reload the record.']);
            }
            BorrowingPolicy::assertCapacity($borrower);
            BorrowingPolicy::assertDates((string) $borrower->borrower_type, $validated['date_borrowed'], $validated['due_date']);
            $borrowing->update($validated + [
                'status' => Borrowing::STATUS_BORROWED,
                'received_by' => $borrowing->borrower?->name,
            ]);
            $borrowing->markOverdueIfNeeded();
            $this->syncBookAvailability($borrowing);
        });

        return back()->with('success', 'Book released. Loan dates and releasing staff have been saved.');
    }

    public function renew(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $validated = $request->validate(['renewal_count' => ['required', 'integer', 'min:0']]);
        DB::transaction(function () use ($borrowing, $validated): void {
            $borrower = Borrower::whereKey($borrowing->borrower_id)->lockForUpdate()->firstOrFail();
            $borrowing = Borrowing::whereKey($borrowing->id)->lockForUpdate()->firstOrFail();
            if (! in_array($borrowing->status, ['borrowed', 'overdue'], true) || $borrowing->date_returned || ! $borrowing->due_date) {
                throw ValidationException::withMessages(['renewal' => 'Only an unreturned, released book can be renewed.']);
            }
            if ($borrowing->renewal_count >= 2) {
                throw ValidationException::withMessages(['renewal' => 'This book has already been renewed twice. Please return it.']);
            }
            if ((int) $validated['renewal_count'] !== $borrowing->renewal_count) {
                throw ValidationException::withMessages(['renewal' => 'This record has already changed. Reload before renewing again.']);
            }
            $renewalStart = $borrowing->due_date->lt(today()) ? today() : $borrowing->due_date;
            $borrowing->forceFill([
                'due_date' => BorrowingPolicy::dueDate((string) $borrower->borrower_type, $renewalStart->toDateString()),
                'renewal_count' => $borrowing->renewal_count + 1,
                'status' => Borrowing::STATUS_BORROWED,
            ])->save();
        });

        return back()->with('success', 'Book renewed. The due date has been extended by one loan period.');
    }

    public function markReturned(Request $request, Borrowing $borrowing): RedirectResponse
    {
        if (! in_array($borrowing->status, [Borrowing::STATUS_BORROWED, Borrowing::STATUS_OVERDUE], true)) {
            return back()->with('error', 'Only a released book can be returned.');
        }

        $validated = $request->validate([
            'returned_by' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($borrowing, $validated): void {
            $borrowing->update([
                'status' => Borrowing::STATUS_RETURNED,
                'date_returned' => now()->toDateString(),
                'returned_by' => trim($validated['returned_by']),
                'remarks' => filled($validated['remarks'] ?? null)
                    ? trim($validated['remarks'])
                    : $borrowing->remarks,
                'returned_processed_by' => auth()->id(),
            ]);

            $borrowing->book?->update([
                'availability_status' => 'available',
            ]);
        });

        return back()->with('success', 'Book marked as returned.');
    }

    public function reject(Borrowing $borrowing): RedirectResponse
    {
        return $this->setStatus(
            $borrowing,
            Borrowing::STATUS_REJECTED,
            'Borrowing request rejected.'
        );
    }

    public function destroy(Borrowing $borrowing): RedirectResponse
    {
        $book = $borrowing->book;

        $borrowing->delete();

        if (
            $book &&
            ! Borrowing::activeForBook((string) $book->accession_number)->exists()
        ) {
            $book->update([
                'availability_status' => 'available',
            ]);
        }

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Erroneous borrowing record deleted.');
    }

    public function borrower(Borrower $borrower): View
    {
        $borrower->load([
            'borrowings' => fn ($query) => $query
                ->with('book')
                ->latest(),
        ]);

        return view('admin.borrowings.borrower', compact('borrower'));
    }

    public function printCard(Borrower $borrower): View
    {
        $borrower->load([
            'borrowings' => fn ($query) => $query
                ->with('book')
                ->orderBy('date_borrowed')->orderBy('id'),
        ]);

        return view('admin.borrowings.print-card', compact('borrower'));
    }

    private function setStatus(
        Borrowing $borrowing,
        string $status,
        string $message
    ): RedirectResponse {
        if ($borrowing->status !== Borrowing::STATUS_PENDING) {
            return back()->with('error', 'Only pending requests can be approved or rejected.');
        }

        if ($status === Borrowing::STATUS_APPROVED && blank($borrowing->accession_number)) {
            return back()->with('error', 'Use Edit Record to assign the book accession number before approving this request.');
        }

        if (
            in_array(
                $status,
                [
                    Borrowing::STATUS_APPROVED,
                    Borrowing::STATUS_BORROWED,
                ],
                true
            ) &&
            $this->bookHasAnotherActiveLoan(
                $borrowing->accession_number,
                $borrowing
            )
        ) {
            return back()->with(
                'error',
                'This book already has another active borrowing transaction.'
            );
        }

        $emails = app(BorrowingEmails::class);
        $emailUpdate = DB::transaction(function () use ($borrowing, $status, $emails) {
            $borrower = Borrower::whereKey($borrowing->borrower_id)->lockForUpdate()->firstOrFail();
            $borrowing = Borrowing::whereKey($borrowing->id)->lockForUpdate()->firstOrFail();
            if ($borrowing->status !== Borrowing::STATUS_PENDING) {
                throw ValidationException::withMessages(['status' => 'This request is no longer pending. Reload the record.']);
            }
            if ($status === Borrowing::STATUS_APPROVED) {
                BorrowingPolicy::assertCapacity($borrower);
            }
            $borrowing->update([
                'status' => $status,
                'released_by' => null,
                'approved_by' => in_array(
                    $status,
                    [
                        Borrowing::STATUS_APPROVED,
                        Borrowing::STATUS_BORROWED,
                    ],
                    true
                )
                    ? auth()->id()
                    : $borrowing->approved_by,
            ]);

            if ($status === Borrowing::STATUS_BORROWED) {
                $borrowing->book?->update([
                    'availability_status' => 'borrowed',
                ]);
            }

            if ($status === Borrowing::STATUS_REJECTED && filled($borrowing->accession_number) && ! Borrowing::activeForBook($borrowing->accession_number)->exists()) {
                $borrowing->book?->update([
                    'availability_status' => 'available',
                ]);
            }

            return $emails->record($borrowing, $status);
        });

        $sent = $emails->send($emailUpdate);

        return back()->with('success', $message.' '.($sent
            ? 'The borrower has been emailed.'
            : 'Email is pending delivery. Check the borrower email address and SMTP settings; the scheduled check will retry.'));
    }

    private function validateBorrowing(
        Request $request,
        Borrowing $borrowing
    ): array {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'id_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('borrowers', 'id_number')
                    ->ignore($borrowing->borrower_id),
            ],

            'borrower_type' => [
                'required',
                Rule::in(['student', 'faculty', 'other']),
            ],

            'borrower_type_other' => ['exclude_unless:borrower_type,other', 'required', 'string', 'max:80'],

            'contact_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'department' => [
                'required',
                'string',
                'max:150',
            ],

            'semester' => [
                'required',
                Rule::in(['1st', '2nd']),
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'accession_number' => [
                Rule::requiredIf(! in_array($borrowing->status, ['pending', 'rejected'], true)),
                'nullable',
                'string',
                'max:100',
            ],

            'bibliographical_description' => [
                'required',
                'string',
                'max:2000',
            ],

            'date_borrowed' => [
                'nullable',
                'date',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'date_returned' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                Rule::in([
                    $borrowing->status,
                ]),
            ],

            'received_by' => [
                'nullable',
                'string',
                'max:255',
            ],

            'returned_by' => [
                'nullable',
                'string',
                'max:255',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'released_by' => [
                Rule::prohibitedIf(! in_array($borrowing->status, ['borrowed', 'overdue', 'returned'], true)),
                'nullable',
                'string',
                'max:255',
            ],
        ]);
    }

    private function borrowingDateError(array $validated): ?array
    {
        $dateBorrowed = $validated['date_borrowed'] ?? null;
        $dueDate = $validated['due_date'] ?? null;
        $dateReturned = $validated['date_returned'] ?? null;
        $status = $validated['status'];

        if ($status !== Borrowing::STATUS_RETURNED && filled($dateReturned)) {
            return ['date_returned' => 'Use Record Return on the borrowing record page to return this book.'];
        }

        if (
            in_array(
                $status,
                [
                    Borrowing::STATUS_BORROWED,
                    Borrowing::STATUS_OVERDUE,
                ],
                true
            ) &&
            (blank($dateBorrowed) || blank($dueDate))
        ) {
            return [
                'date_borrowed' =>
                    'Date borrowed and due date are required before marking a request as borrowed or overdue.',
            ];
        }

        if (
            $status === Borrowing::STATUS_RETURNED &&
            (
                blank($dateBorrowed) ||
                blank($dueDate) ||
                blank($dateReturned)
            )
        ) {
            return [
                'date_returned' =>
                    'Date borrowed, due date, and date returned are required before marking a request as returned.',
            ];
        }

        if (
            filled($dateBorrowed) &&
            filled($dueDate) &&
            $dueDate < $dateBorrowed
        ) {
            return [
                'due_date' =>
                    'The due date cannot be earlier than the date borrowed.',
            ];
        }

        if (
            filled($dateBorrowed) &&
            filled($dateReturned) &&
            $dateReturned < $dateBorrowed
        ) {
            return [
                'date_returned' =>
                    'The return date cannot be earlier than the date borrowed.',
            ];
        }

        return null;
    }

    private function bookHasAnotherActiveLoan(
        string $accessionNumber,
        Borrowing $borrowing
    ): bool {
        return Borrowing::activeForBook($accessionNumber)
            ->whereKeyNot($borrowing->id)
            ->exists();
    }

    private function syncBookAvailability(
        Borrowing $borrowing,
        ?int $oldBookId = null
    ): void {
        if (
            $oldBookId &&
            $oldBookId !== $borrowing->new_arrival_id
        ) {
            $oldBook = NewArrival::find($oldBookId);

            if (
                $oldBook &&
                ! Borrowing::activeForBook(
                    (string) $oldBook->accession_number
                )->exists()
            ) {
                $oldBook->update([
                    'availability_status' => 'available',
                ]);
            }
        }

        if (
            in_array(
                $borrowing->status,
                [
                    Borrowing::STATUS_BORROWED,
                    Borrowing::STATUS_OVERDUE,
                ],
                true
            )
        ) {
            $borrowing->book?->update([
                'availability_status' => 'borrowed',
            ]);
        }

        if (
            ! Borrowing::activeForBook($borrowing->accession_number)->exists() && in_array(
                $borrowing->status,
                [
                    Borrowing::STATUS_RETURNED,
                    Borrowing::STATUS_REJECTED,
                ],
                true
            )
        ) {
            $borrowing->book?->update([
                'availability_status' => 'available',
            ]);
        }
    }

    private function refreshOverdueBorrowings(): void
    {
        Borrowing::query()
            ->whereIn('status', [
                Borrowing::STATUS_BORROWED,
            ])
            ->whereNull('date_returned')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->update([
                'status' => Borrowing::STATUS_OVERDUE,
            ]);
    }
}
