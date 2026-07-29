<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EbookProgram;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EbookProgramController extends Controller
{
    /**
     * Display all e-book programs alphabetically.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $programs = EbookProgram::query()
            ->withCount('folders')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        );
                });
            })
            ->orderBy('title', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.ebooks.programs.index',
            compact('programs')
        );
    }

    /**
     * Show the program creation form.
     */
    public function create(): View
    {
        return view('admin.ebooks.programs.create');
    }

    /**
     * Store a new e-book program.
     */
    public function store(Request $request): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['ebook_programs']);

        $data = $this->validateAndPrepareProgram($request);

        EbookProgram::create($data);

        return redirect()
            ->route('admin.ebook-programs.index')
            ->with(
                'success',
                'E-book program added successfully.'
            );
    }

    /**
     * Show the program editing form.
     */
    public function edit(EbookProgram $ebookProgram): View
    {
        return view(
            'admin.ebooks.programs.edit',
            compact('ebookProgram')
        );
    }

    /**
     * Update an existing e-book program.
     */
    public function update(
        Request $request,
        EbookProgram $ebookProgram
    ): RedirectResponse {
        DatabaseMedia::ensureBlobColumns(['ebook_programs']);

        $oldImage = $ebookProgram->image;

        $data = $this->validateAndPrepareProgram(
            $request,
            $ebookProgram
        );

        $ebookProgram->update($data);

        /*
         * Delete the previous local image when it
         * was replaced by another image.
         */
        if (
            array_key_exists('image', $data) &&
            $data['image'] !== $oldImage &&
            $this->isUploadedImage($oldImage)
        ) {
            //
        }

        return redirect()
            ->route('admin.ebook-programs.index')
            ->with(
                'success',
                'E-book program updated successfully.'
            );
    }

    /**
     * Delete an e-book program.
     */
    public function destroy(
        EbookProgram $ebookProgram
    ): RedirectResponse {
        /*
         * Prevent deleting a program that still
         * contains e-book folders.
         */
        if ($ebookProgram->folders()->exists()) {
            return redirect()
                ->route('admin.ebook-programs.index')
                ->with(
                    'error',
                    'This program cannot be deleted because it still has e-book folders. Delete the folders first.'
                );
        }

        if ($this->isUploadedImage($ebookProgram->image)) {
            //
        }

        $ebookProgram->delete();

        return redirect()
            ->route('admin.ebook-programs.index')
            ->with(
                'success',
                'E-book program deleted successfully.'
            );
    }

    /**
     * Validate and prepare program information.
     */
    private function validateAndPrepareProgram(
        Request $request,
        ?EbookProgram $ebookProgram = null
    ): array {
        /*
         * Default to Active if the status field
         * is unexpectedly missing.
         */
        $request->merge([
            'status' => (string) $request->input(
                'status',
                '1'
            ),
        ]);

        $validated = $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'image_file' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],

                'image_url' => [
                    'nullable',
                    'url',
                    'max:2048',
                ],

                'status' => [
                    'required',
                    Rule::in(['0', '1']),
                ],
            ],
            [
                'title.required' =>
                    'The program title is required.',

                'title.max' =>
                    'The program title must not exceed 255 characters.',

                'image_file.image' =>
                    'The uploaded file must be an image.',

                'image_file.mimes' =>
                    'The cover must be a JPG, JPEG, PNG, or WEBP image.',

                'image_file.max' =>
                    'The cover image must not exceed 5 MB.',

                'image_url.url' =>
                    'Enter a valid image URL.',

                'image_url.max' =>
                    'The image URL must not exceed 2,048 characters.',

                'status.required' =>
                    'Please select a status.',

                'status.in' =>
                    'The selected status is invalid.',
            ]
        );

        $data = [
            'title' =>
                trim($validated['title']),

            'description' =>
                filled($validated['description'] ?? null)
                    ? trim($validated['description'])
                    : null,

            'status' =>
                (int) $validated['status'],
        ];

        /*
         * An uploaded image takes priority over
         * an external image URL.
         */
        if ($request->hasFile('image_file')) {
            $data['image'] = DatabaseMedia::store(
                $request->file('image_file')
            );
        } elseif (filled($validated['image_url'] ?? null)) {
            $data['image'] = trim(
                $validated['image_url']
            );
        } elseif (!$ebookProgram) {
            $data['image'] = null;
        }

        return $data;
    }

    /**
     * Determine whether an image is stored locally.
     */
    private function isUploadedImage(?string $image): bool
    {
        if (blank($image)) {
            return false;
        }

        return !str_starts_with($image, 'http://') &&
            !str_starts_with($image, 'https://') &&
            !str_starts_with($image, 'data:');
    }
}
