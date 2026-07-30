<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThesisProgram;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ThesisProgramController extends Controller
{
    /**
     * Display all thesis/dissertation programs alphabetically.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $programs = ThesisProgram::query()
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
            'admin.theses.programs.index',
            compact('programs')
        );
    }

    /**
     * Show the program creation form.
     */
    public function create(): View
    {
        return view('admin.theses.programs.create');
    }

    /**
     * Store a new thesis/dissertation program.
     */
    public function store(Request $request): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['thesis_programs']);

        $data = $this->validateAndPrepareProgram($request);

        ThesisProgram::create($data);

        return redirect()
            ->route('admin.thesis-programs.index')
            ->with(
                'success',
                'Thesis and dissertation program added successfully.'
            );
    }

    /**
     * Show the program editing form.
     */
    public function edit(ThesisProgram $thesisProgram): View
    {
        return view(
            'admin.theses.programs.edit',
            compact('thesisProgram')
        );
    }

    /**
     * Update an existing thesis/dissertation program.
     */
    public function update(
        Request $request,
        ThesisProgram $thesisProgram
    ): RedirectResponse {
        DatabaseMedia::ensureBlobColumns(['thesis_programs']);

        $oldImage = $thesisProgram->image;

        $data = $this->validateAndPrepareProgram(
            $request,
            $thesisProgram
        );

        $thesisProgram->update($data);

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
            ->route('admin.thesis-programs.index')
            ->with(
                'success',
                'Thesis and dissertation program updated successfully.'
            );
    }

    /**
     * Delete an thesis/dissertation program.
     */
    public function destroy(
        ThesisProgram $thesisProgram
    ): RedirectResponse {
        /*
         * Prevent deleting a program that still
         * contains thesis/dissertation folders.
         */
        if ($thesisProgram->folders()->exists()) {
            return redirect()
                ->route('admin.thesis-programs.index')
                ->with(
                    'error',
                    'This program cannot be deleted because it still has thesis and dissertation folders. Delete the folders first.'
                );
        }

        if ($this->isUploadedImage($thesisProgram->image)) {
            //
        }

        $thesisProgram->delete();

        return redirect()
            ->route('admin.thesis-programs.index')
            ->with(
                'success',
                'Thesis and dissertation program deleted successfully.'
            );
    }

    /**
     * Validate and prepare program information.
     */
    private function validateAndPrepareProgram(
        Request $request,
        ?ThesisProgram $thesisProgram = null
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
                    Rule::unique('thesis_programs', 'title')->ignore(
                        $thesisProgram?->id
                    ),
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

                'title.unique' =>
                    'This program name already exists.',

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
        } elseif (!$thesisProgram) {
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
