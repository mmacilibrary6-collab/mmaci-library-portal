<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Borrowing;
use App\Models\NewArrival;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BorrowBookController extends Controller
{
    public function create(): View
    {
        $books = NewArrival::query()
            ->whereNotNull('accession_number')
            ->where('accession_number', '!=', '')
            ->where(function ($query) {
                $query
                    ->whereNull('availability_status')
                    ->orWhere('availability_status', 'available');
            })
            ->whereDoesntHave('borrowings', function ($query) {
                $query
                    ->whereIn('status', [
                        Borrowing::STATUS_PENDING,
                        Borrowing::STATUS_APPROVED,
                        Borrowing::STATUS_BORROWED,
                        Borrowing::STATUS_OVERDUE,
                    ])
                    ->whereNull('date_returned');
            })
            ->orderBy('title')
            ->get();

        return view('more.borrow-books.create', compact('books'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:100'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:150'],
            'semester' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'accession_number' => [
                'required',
                'string',
                'max:100',
                Rule::exists('new_arrivals', 'accession_number'),
            ],
            'date_borrowed' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:date_borrowed'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ], [
            'accession_number.exists' => 'Please select a valid book accession number from the catalog.',
            'due_date.after_or_equal' => 'The due date cannot be earlier than the date borrowed.',
        ]);

        $book = NewArrival::query()
            ->where('accession_number', $validated['accession_number'])
            ->firstOrFail();

        if (($book->availability_status ?? 'available') !== 'available') {
            return back()
                ->withInput()
                ->withErrors(['accession_number' => 'This book is currently unavailable for borrowing.']);
        }

        if (Borrowing::activeForBook($validated['accession_number'])->exists()) {
            return back()
                ->withInput()
                ->withErrors(['accession_number' => 'This book already has an active borrowing request or loan.']);
        }

        DB::transaction(function () use ($validated, $book): void {
            $borrower = Borrower::updateOrCreate(
                ['id_number' => trim($validated['id_number'])],
                [
                    'name' => trim($validated['name']),
                    'contact_number' => filled($validated['contact_number'] ?? null) ? trim($validated['contact_number']) : null,
                    'department' => trim($validated['department']),
                    'semester' => filled($validated['semester'] ?? null) ? trim($validated['semester']) : null,
                    'email' => filled($validated['email'] ?? null) ? trim($validated['email']) : null,
                ]
            );

            Borrowing::create([
                'borrower_id' => $borrower->id,
                'new_arrival_id' => $book->id,
                'accession_number' => $book->accession_number,
                'bibliographical_description' => $this->bibliographicalDescription($book),
                'date_borrowed' => $validated['date_borrowed'],
                'due_date' => $validated['due_date'],
                'status' => Borrowing::STATUS_PENDING,
                'remarks' => filled($validated['remarks'] ?? null) ? trim($validated['remarks']) : null,
            ]);
        });

        return redirect()
            ->route('more.borrow-books')
            ->with('success', 'Your borrowing request was submitted. Please wait for library approval.');
    }

    private function bibliographicalDescription(NewArrival $book): string
    {
        return collect([
            $book->title,
            $book->author ? 'by '.$book->author : null,
            $book->publisher,
            $book->publication_year,
        ])->filter()->implode(' ');
    }
}
