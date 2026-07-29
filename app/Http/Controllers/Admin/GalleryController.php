<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->with('images')
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
        $validated = $request->validate(
            $this->rules(),
            $this->messages()
        );

        $gallery = Gallery::create([
            'title' => trim($validated['title']),
            'is_active' =>
                $request->boolean('is_active'),
        ]);

        $this->storeGalleryImages(
            $gallery,
            $request->file('images', [])
        );

        return redirect()
            ->route('admin.gallery.index')
            ->with(
                'success',
                'Gallery image added successfully.'
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
        $validated = $request->validate(
            $this->rules(false),
            $this->messages()
        );

        $data = [
            'title' => trim($validated['title']),
            'is_active' =>
                $request->boolean('is_active'),
        ];

        $gallery->update($data);
        $this->storeGalleryImages(
            $gallery,
            $request->file('images', [])
        );

        return redirect()
            ->route('admin.gallery.index')
            ->with(
                'success',
                'Gallery image updated successfully.'
            );
    }

    /**
     * Delete a gallery image.
     */
    public function destroy(
        Gallery $gallery
    ): RedirectResponse {
        if (
            $gallery->images->isNotEmpty()
        ) {
            foreach ($gallery->images as $galleryImage) {
                Storage::disk('public')->delete(
                    $this->normalizeLocalImagePath($galleryImage->image)
                );
            }
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with(
                'success',
                'Gallery image deleted successfully.'
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

            'images' => [
                $imageRequired ? 'required' : 'nullable',
                'array',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:10240',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
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

            'images.required' =>
                'Please select at least one image.',

            'images.array' =>
                'The image upload is invalid.',

            'images.*.image' =>
                'The uploaded file must be an image.',

            'images.*.mimes' =>
                'Images must be JPG, JPEG, PNG, WEBP, or GIF files.',

            'images.*.max' =>
                'Each image must not exceed 10 MB.',
        ];
    }

    private function normalizeLocalImagePath(?string $image): string
    {
        $image = trim((string) $image);

        if (str_starts_with($image, 'storage/')) {
            $image = substr($image, 8);
        }

        return ltrim($image, '/');
    }

    private function storeGalleryImages(Gallery $gallery, array $files): void
    {
        foreach ($files as $file) {
            if (!$file) {
                continue;
            }

            $gallery->images()->create([
                'image' => $file->store('gallery', 'public'),
            ]);
        }
    }
}
