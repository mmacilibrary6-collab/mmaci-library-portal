<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Borrowing;
use App\Services\BorrowingPolicy;
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
        if (filled($request->input('website'))) {
            throw ValidationException::withMessages(['request' => 'Unable to submit this request. Please reload the form and try again.']);
        }
        foreach (['name', 'id_number', 'book_title', 'email'] as $field) {
            if (is_string($request->input($field))) {
                $value = \Illuminate\Support\Str::squish($request->input($field));
                $request->merge([$field => $field === 'email' ? mb_strtolower($value) : $value]);
            }
        }
        $validated = $request->validate([
            'borrower_type' => ['required', 'in:student,faculty,other'],
            'borrower_type_other' => ['exclude_unless:borrower_type,other', 'required', 'string', 'max:80'],

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
                'required',
                'email',
                'max:255',
            ],

            'book_title' => ['required', 'string', 'max:500'],
        ]);

        $idNumber = trim($validated['id_number']);
        $name = trim($validated['name']);
        $borrowerType = $validated['borrower_type'];
        $bookTitle = trim($validated['book_title']);

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

        DB::transaction(function () use ($validated, $idNumber, $name, $borrowerType, $bookTitle): void {
            $borrower = Borrower::firstOrCreate(['id_number' => $idNumber], [
                'name' => $name,
                'borrower_type' => $borrowerType,
                'borrower_type_other' => $borrowerType === 'other' ? trim($validated['borrower_type_other']) : null,
                'contact_number' => $validated['contact_number'] ?? null,
                'department' => $validated['department'],
                'semester' => $validated['semester'],
                'email' => $validated['email'],
            ]);
            $borrower = Borrower::whereKey($borrower->id)->lockForUpdate()->firstOrFail();
            if (mb_strtolower(\Illuminate\Support\Str::squish($borrower->name)) !== mb_strtolower($name)
                || (filled($borrower->borrower_type) && $borrower->borrower_type !== $borrowerType)
                || blank($borrower->email)
                || mb_strtolower(trim($borrower->email)) !== $validated['email']) {
                throw ValidationException::withMessages(['id_number' => 'These details do not match the existing borrower record. Please contact library staff to verify or update your information.']);
            }
            // Public submissions must not overwrite an existing borrower's contact details.
            if (blank($borrower->borrower_type)) {
                $borrower->update(['borrower_type' => $borrowerType, 'borrower_type_other' => $borrowerType === 'other' ? trim($validated['borrower_type_other']) : null]);
            }
            $outstanding = $borrower->borrowings()->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue'])->whereNull('date_returned')->get();
            foreach ($outstanding as $record) {
                if (mb_strtolower(\Illuminate\Support\Str::squish($record->bibliographical_description)) === mb_strtolower($bookTitle)) {
                    throw ValidationException::withMessages(['book_title' => 'You already have an active request or borrowing record for this book.']);
                }
            }
            BorrowingPolicy::assertCapacity($borrower);
            if ($outstanding->count() >= BorrowingPolicy::limit($borrowerType)) {
                throw ValidationException::withMessages(['book_title' => 'You have reached your outstanding request limit. Please wait for library staff to review your requests or return a borrowed book before requesting another.']);
            }
            Borrowing::create([
                'borrower_id' => $borrower->id,
                'bibliographical_description' => $bookTitle,
                'status' => Borrowing::STATUS_PENDING,
            ]);
        }, 3);

        return redirect()
            ->route('more.borrow-books')
            ->with(
                'success',
                'Your borrowing request was submitted. We will email you when the library approves or rejects it.'
            );
    }
}
