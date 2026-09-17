<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BorrowBookController extends Controller
{
    public function create(): View
    {
        return view('more.borrow-books.create');
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
            ],
            'bibliographical_description' => ['required', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($validated): void {
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
                'new_arrival_id' => null,
                'accession_number' => trim($validated['accession_number']),
                'bibliographical_description' => trim($validated['bibliographical_description']),
                'status' => Borrowing::STATUS_PENDING,
            ]);
        });

        return redirect()
            ->route('more.borrow-books')
            ->with('success', 'Your borrowing request was submitted. Please wait for library approval.');
    }
}
