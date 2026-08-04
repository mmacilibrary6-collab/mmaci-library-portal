<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonatedBook;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonatedBookController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $books = DonatedBook::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('admin.donated-books.index', compact('books'));
    }

    public function create(): View
    {
        return view('admin.donated-books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['donated_books']);

        $data = $this->validateAndPrepare($request, true);

        DonatedBook::create($data);

        return redirect()
            ->route('admin.donated-books.index')
            ->with('success', 'Donated book added successfully.');
    }

    public function edit(DonatedBook $donatedBook): View
    {
        return view('admin.donated-books.edit', compact('donatedBook'));
    }

    public function update(Request $request, DonatedBook $donatedBook): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['donated_books']);

        $data = $this->validateAndPrepare($request, false, $donatedBook);
        $donatedBook->update($data);

        return redirect()
            ->route('admin.donated-books.index')
            ->with('success', 'Donated book updated successfully.');
    }

    public function destroy(DonatedBook $donatedBook): RedirectResponse
    {
        $donatedBook->delete();

        return redirect()
            ->route('admin.donated-books.index')
            ->with('success', 'Donated book deleted successfully.');
    }

    private function validateAndPrepare(
        Request $request,
        bool $isCreating = false,
        ?DonatedBook $donatedBook = null
    ): array {
        $request->merge([
            'status' => (string) $request->input('status', '1'),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_file' => [
                $isCreating ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:0,1'],
        ], [
            'title.required' => 'The donated book title is required.',
            'title.max' => 'The title must not exceed 255 characters.',
            'image_file.required' => 'Please upload a donated book image.',
            'image_file.image' => 'The uploaded file must be an image.',
            'image_file.mimes' => 'The image must be a JPG, JPEG, PNG, or WEBP file.',
            'image_file.max' => 'The image must not exceed 5 MB.',
        ]);

        $data = [
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null)
                ? trim($validated['description'])
                : null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('image_file')) {
            $data['image'] = DatabaseMedia::store($request->file('image_file'));
        } elseif (!$donatedBook) {
            $data['image'] = null;
        } else {
            $data['image'] = $donatedBook->image;
        }

        return $data;
    }
}
