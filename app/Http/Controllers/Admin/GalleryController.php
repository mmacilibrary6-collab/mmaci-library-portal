<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display all gallery records.
     */
    public function index(Request $request): View
    {
        $search = trim(
            (string) $request->input('search')
        );

        $status = $request->input('status');

        $galleries = Gallery::query()
            ->withCount('images')
            ->with(['images' => fn ($query) => $query->latest('created_at')])
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(
                        'title',
                        'like',
                        "%{$search}%"
                    );
                }
            )
            ->when(
                $status === 'active',
                fn ($query) => $query->where(
                    'is_active',
                    true
                )
            )
            ->when(
                $status === 'inactive',
                fn ($query) => $query->where(
                    'is_active',
                    false
                )
            )
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'admin.gallery.list',
            compact('galleries')
        );
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a gallery image.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        DatabaseMedia::ensureBlobColumns(['galleries', 'gallery_images']);

        $validated = $request->validate(
            $this->rules(),
            $this->messages()
        );

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = DatabaseMedia::store(
                $request->file('image')
            );
        }

        Gallery::create([
            'title' => trim($validated['title']),
            'image' => $imagePath,
            'is_active' =>
                $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.gallery.index')
            ->with(
                'success',
                'Gallery folder added successfully.'
            );
    }

    /**
     * Show the edit form.
     */
    public function edit(
        Gallery $gallery
    ): View {
        return view(
            'admin.gallery.edit',
            compact('gallery')
        );
    }

    /**
     * Update a gallery image.
     */
    public function update(
        Request $request,
        Gallery $gallery
    ): RedirectResponse {
        DatabaseMedia::ensureBlobColumns(['galleries']);

        $validated = $request->validate(
            $this->rules(false),
            $this->messages()
        );

        $data = [
            'title' => trim($validated['title']),
            'is_active' =>
                $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = DatabaseMedia::store(
                $request->file('image')
            );
        }

        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with(
                'success',
                'Gallery folder updated successfully.'
            );
    }

    public function storeImage(
        Request $request,
        Gallery $gallery
    ): RedirectResponse {
        DatabaseMedia::ensureBlobColumns(['gallery_images']);

        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'images.required' =>
                'Please select at least one image.',
            'images.array' =>
                'Please select at least one image.',
            'images.min' =>
                'Please select at least one image.',
            'images.*.image' =>
                'Each uploaded file must be an image.',
            'images.*.mimes' =>
                'Images must be JPG, JPEG, PNG, or WEBP files.',
            'images.*.max' =>
                'Each image must not exceed 5 MB.',
        ]);

        foreach ($request->file('images', []) as $imageFile) {
            $gallery->images()->create([
                'image' => DatabaseMedia::store($imageFile),
            ]);
        }

        return redirect()
            ->route('admin.gallery.edit', $gallery)
            ->with('success', 'Gallery images added successfully.');
    }

    /**
     * Delete a gallery image.
     */
    public function destroy(
        Gallery $gallery
    ): RedirectResponse {
        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with(
                'success',
                'Gallery folder deleted successfully.'
            );
    }

    /**
     * Validation rules.
     */
    private function rules(
        bool $imageRequired = true
    ): array {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                $imageRequired
                    ? 'required'
                    : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom validation messages.
     */
    private function messages(): array
    {
        return [
            'title.required' =>
                'The gallery title is required.',

            'title.max' =>
                'The title must not exceed 255 characters.',

            'image.required' =>
                'Please select an image.',

            'image.image' =>
                'The uploaded file must be an image.',

            'image.mimes' =>
                'The image must be a JPG, JPEG, PNG, or WEBP file.',

            'image.max' =>
                'The image must not exceed 5 MB.',
        ];
    }
}
