<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryUpdate;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryUpdateController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $updates = LibraryUpdate::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.library-updates.index', compact('updates'));
    }

    public function create(): View
    {
        return view('admin.library-updates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['library_updates']);

        $data = $this->validateAndPrepare($request, true);

        LibraryUpdate::create($data);

        return redirect()
            ->route('admin.library-updates.index')
            ->with('success', 'Library update created successfully.');
    }

    public function edit(LibraryUpdate $libraryUpdate): View
    {
        return view('admin.library-updates.edit', compact('libraryUpdate'));
    }

    public function update(Request $request, LibraryUpdate $libraryUpdate): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['library_updates']);

        $data = $this->validateAndPrepare($request, false, $libraryUpdate);
        $libraryUpdate->update($data);

        return redirect()
            ->route('admin.library-updates.index')
            ->with('success', 'Library update updated successfully.');
    }

    public function destroy(LibraryUpdate $libraryUpdate): RedirectResponse
    {
        $libraryUpdate->delete();

        return redirect()
            ->route('admin.library-updates.index')
            ->with('success', 'Library update deleted successfully.');
    }

    private function validateAndPrepare(
        Request $request,
        bool $isCreating = false,
        ?LibraryUpdate $libraryUpdate = null
    ): array
    {
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
                'max:5120'
            ],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:0,1'],
        ], [
            'title.required' => 'The update title is required.',
            'title.max' => 'The update title must not exceed 255 characters.',
            'image_file.required' => 'Please upload a library update image.',
            'image_file.image' => 'The uploaded file must be an image.',
            'image_file.mimes' => 'The image must be a JPG, JPEG, PNG, or WEBP file.',
            'image_file.max' => 'The image must not exceed 5 MB.',
        ]);

        $data = [
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('image_file')) {
            $data['image'] = DatabaseMedia::store($request->file('image_file'));
        } elseif (!$libraryUpdate) {
            $data['image'] = null;
        } else {
            $data['image'] = $libraryUpdate->image;
        }

        return $data;
    }
}
