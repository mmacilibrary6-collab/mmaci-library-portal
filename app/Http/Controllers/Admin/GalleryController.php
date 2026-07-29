<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            ->orderBy('sort_order')
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

        $imagePath = $request
            ->file('image')
            ->store('gallery', 'public');

        Gallery::create([
            'title' => trim($validated['title']),
            'image' => $imagePath,
            'sort_order' =>
                (int) ($validated['sort_order'] ?? 0),
            'is_active' =>
                $request->boolean('is_active'),
        ]);

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
            'sort_order' =>
                (int) ($validated['sort_order'] ?? 0),
            'is_active' =>
                $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $oldImage = $gallery->image;

            $data['image'] = $request
                ->file('image')
                ->store('gallery', 'public');

            if (
                filled($oldImage) &&
                !str_starts_with($oldImage, 'http://') &&
                !str_starts_with($oldImage, 'https://')
            ) {
                Storage::disk('public')
                    ->delete($oldImage);
            }
        }

        $gallery->update($data);

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
            filled($gallery->image) &&
            !str_starts_with(
                $gallery->image,
                'http://'
            ) &&
            !str_starts_with(
                $gallery->image,
                'https://'
            )
        ) {
            Storage::disk('public')
                ->delete($gallery->image);
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

            'image' => [
                $imageRequired
                    ? 'required'
                    : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:9999',
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

            'image.required' =>
                'Please select an image.',

            'image.image' =>
                'The uploaded file must be an image.',

            'image.mimes' =>
                'The image must be a JPG, JPEG, PNG, or WEBP file.',

            'image.max' =>
                'The image must not exceed 5 MB.',

            'sort_order.integer' =>
                'The sort order must be a number.',

            'sort_order.min' =>
                'The sort order cannot be negative.',
        ];
    }
}