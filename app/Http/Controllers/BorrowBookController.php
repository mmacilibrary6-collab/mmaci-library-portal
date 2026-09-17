<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Borrowing;
use App\Models\NewArrival;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
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
            'borrower_type' => ['required', 'in:student,faculty'],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'id_number' => [
                'required',
                'string',
                'max:100',
            ],

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
                'in:1st,2nd',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'accession_number' => [
                'required',
                'string',
                'max:100',
            ],

            'bibliographical_description' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $idNumber = trim($validated['id_number']);
        $name = trim($validated['name']);
        $borrowerType = $validated['borrower_type'];
        $accessionNumber = trim($validated['accession_number']);

        /*
        |--------------------------------------------------------------------------
        | Check Existing Borrower
        |--------------------------------------------------------------------------
        |
        | One ID number = one borrower record.
        |
        | If this borrower already exists, we reuse that borrower instead of
        | creating another borrower row.
        |
        */

        $existingBorrower = Borrower::query()
            ->where('id_number', $idNumber)
            ->first();

        if ($existingBorrower) {

            /*
             * Prevent another person from using an existing ID number.
             *
             * Capitalization does not matter:
             *
             * "Janze Salva"
             * "JANZE SALVA"
             *
             * are considered the same.
             */

            $existingName = mb_strtolower(trim($existingBorrower->name));
            $submittedName = mb_strtolower($name);

            if ($existingName !== $submittedName) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'id_number' =>
                            'This ID number is already registered to another borrower. Please check the ID number and name.',
                    ]);
            }

            /*
             * If an old borrower record does not yet have a borrower type,
             * allow this submission to assign Student/Faculty.
             *
             * If it already has a type, prevent the public form from silently
             * changing Student to Faculty or vice versa.
             */

            if (
                filled($existingBorrower->borrower_type) &&
                $existingBorrower->borrower_type !== $borrowerType
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'borrower_type' =>
                            'The selected borrower type does not match the existing borrower record.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Active Request
        |--------------------------------------------------------------------------
        |
        | The SAME borrower should not be able to request the SAME accession
        | number again while an existing request/loan is still active.
        |
        */

        if ($existingBorrower) {
            $duplicateRequest = Borrowing::query()
                ->where('borrower_id', $existingBorrower->id)
                ->where('accession_number', $accessionNumber)
                ->whereIn('status', [
                    Borrowing::STATUS_PENDING,
                    Borrowing::STATUS_APPROVED,
                    Borrowing::STATUS_BORROWED,
                    Borrowing::STATUS_OVERDUE,
                ])
                ->exists();

            if ($duplicateRequest) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'accession_number' =>
                            'You already have an active request or borrowing record for this book.',
                    ]);
            }
        }

        DB::transaction(function () use (
            $validated,
            $existingBorrower,
            $idNumber,
            $name,
            $borrowerType,
            $accessionNumber
        ): void {

            /*
            |--------------------------------------------------------------------------
            | Create or Update Borrower
            |--------------------------------------------------------------------------
            */

            if ($existingBorrower) {

                $borrower = $existingBorrower;

                /*
                 * Keep the same borrower record but refresh information that
                 * may legitimately change over time.
                 */

                $borrower->update([
                    'borrower_type' => filled($borrower->borrower_type)
                        ? $borrower->borrower_type
                        : $borrowerType,

                    'contact_number' =>
                        filled($validated['contact_number'] ?? null)
                            ? trim($validated['contact_number'])
                            : null,

                    'department' =>
                        trim($validated['department']),

                    'semester' =>
                        $validated['semester'],

                    'email' =>
                        filled($validated['email'] ?? null)
                            ? trim($validated['email'])
                            : null,
                ]);

            } else {

                $borrower = Borrower::create([
                    'name' => $name,

                    'id_number' => $idNumber,

                    'borrower_type' => $borrowerType,

                    'contact_number' =>
                        filled($validated['contact_number'] ?? null)
                            ? trim($validated['contact_number'])
                            : null,

                    'department' =>
                        trim($validated['department']),

                    'semester' =>
                        $validated['semester'],

                    'email' =>
                        filled($validated['email'] ?? null)
                            ? trim($validated['email'])
                            : null,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Double Check Duplicate Request
            |--------------------------------------------------------------------------
            |
            | We check again inside the transaction so new/existing borrowers
            | follow the same rule.
            |
            */

            $duplicateRequest = Borrowing::query()
                ->where('borrower_id', $borrower->id)
                ->where('accession_number', $accessionNumber)
                ->whereIn('status', [
                    Borrowing::STATUS_PENDING,
                    Borrowing::STATUS_APPROVED,
                    Borrowing::STATUS_BORROWED,
                    Borrowing::STATUS_OVERDUE,
                ])
                ->exists();

            if ($duplicateRequest) {
                throw ValidationException::withMessages([
                    'accession_number' =>
                        'You already have an active request or borrowing record for this book.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Find Book From New Arrivals
            |--------------------------------------------------------------------------
            |
            | Your old code always stored:
            |
            | new_arrival_id => null
            |
            | This meant the borrowing record was not connected to the actual
            | NewArrival book, so availability updates from the admin controller
            | could fail.
            |
            */

            $book = NewArrival::query()
                ->where('accession_number', $accessionNumber)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Create NEW Borrowing Transaction
            |--------------------------------------------------------------------------
            |
            | We do NOT create another borrower.
            |
            | We create another borrowing history record belonging to the same
            | borrower.
            |
            */

            Borrowing::create([
                'borrower_id' => $borrower->id,

                'new_arrival_id' => $book?->id,

                'accession_number' =>
                    $accessionNumber,

                'bibliographical_description' =>
                    trim($validated['bibliographical_description']),

                'status' =>
                    Borrowing::STATUS_PENDING,

                'date_borrowed' => null,
                'due_date' => null,
                'date_returned' => null,

                'received_by' => null,
                'returned_by' => null,
                'remarks' => null,
            ]);
        });

        return redirect()
            ->route('more.borrow-books')
            ->with(
                'success',
                'Your borrowing request was submitted. Please wait for library approval.'
            );
    }
}