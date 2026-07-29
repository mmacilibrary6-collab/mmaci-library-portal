<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AskLibrarian;
use Illuminate\Http\Request;

class AskLibrarianController extends Controller
{
    /**
     * Display all inquiries.
     */
    public function index()
    {
        $questions = AskLibrarian::latest()->paginate(10);

        return view('admin.ask-librarian.index', compact('questions'));
    }

    /**
     * Display a single inquiry.
     */
    public function show(AskLibrarian $askLibrarian)
    {
        return view('admin.ask-librarian.show', compact('askLibrarian'));
    }

    /**
     * Update inquiry status or response.
     */
    public function update(Request $request, AskLibrarian $askLibrarian)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,answered',
            'response' => 'nullable|string',
        ]);

        $askLibrarian->update($validated);

        return redirect()
            ->route('admin.ask-librarian.index')
            ->with('success', 'Inquiry updated successfully.');
    }

    /**
     * Delete an inquiry.
     */
    public function destroy(AskLibrarian $askLibrarian)
    {
        $askLibrarian->delete();

        return redirect()
            ->route('admin.ask-librarian.index')
            ->with('success', 'Inquiry deleted successfully.');
    }
}