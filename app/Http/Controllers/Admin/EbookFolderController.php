<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EbookFolder;
use App\Models\EbookProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EbookFolderController extends Controller
{
    /**
     * Display all e-book folders alphabetically.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $programId = $request->input('program');

        /*
        |--------------------------------------------------------------------------
        | Academic programs for the filter
        |--------------------------------------------------------------------------
        */

        $programs = EbookProgram::query()
            ->orderBy('title', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | E-book folders sorted alphabetically
        |--------------------------------------------------------------------------
        */

        $folders = EbookFolder::query()
            ->with('program')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('drive_link', 'like', "%{$search}%")
                        ->orWhereHas(
                            'program',
                            function ($programQuery) use ($search) {
                                $programQuery->where(
                                    'title',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        );
                });
            })
            ->when(
                filled($programId),
                function ($query) use ($programId) {
                    $query->where(
                        'ebook_program_id',
                        $programId
                    );
                }
            )
            ->orderBy('title', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.ebooks.folders.index',
            compact('folders', 'programs')
        );
    }

    /**
     * Show the folder creation form.
     */
    public function create(Request $request): View
    {
        $programs = EbookProgram::query()
            ->orderBy('title', 'asc')
            ->get();

        $selectedProgramId = $request->input('program');

        return view(
            'admin.ebooks.folders.create',
            compact('programs', 'selectedProgramId')
        );
    }

    /**
     * Store a newly created folder.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateAndPrepareFolder($request);

        EbookFolder::create($data);

        return redirect()
            ->route('admin.ebook-folders.index')
            ->with(
                'success',
                'E-book folder created successfully.'
            );
    }

    /**
     * Show the folder editing form.
     */
    public function edit(EbookFolder $ebookFolder): View
    {
        $programs = EbookProgram::query()
            ->orderBy('title', 'asc')
            ->get();

        return view(
            'admin.ebooks.folders.edit',
            compact('ebookFolder', 'programs')
        );
    }

    /**
     * Update an existing folder.
     */
    public function update(
        Request $request,
        EbookFolder $ebookFolder
    ): RedirectResponse {
        $data = $this->validateAndPrepareFolder($request, $ebookFolder);

        $ebookFolder->update($data);

        return redirect()
            ->route('admin.ebook-folders.index')
            ->with(
                'success',
                'E-book folder updated successfully.'
            );
    }

    /**
     * Delete the specified folder.
     */
    public function destroy(
        EbookFolder $ebookFolder
    ): RedirectResponse {
        $ebookFolder->delete();

        return redirect()
            ->route('admin.ebook-folders.index')
            ->with(
                'success',
                'E-book folder deleted successfully.'
            );
    }

    /**
     * Validate and prepare folder information.
     */
    private function validateAndPrepareFolder(
        Request $request,
        ?EbookFolder $ebookFolder = null
    ): array {
        /*
         * Use Active as the default if the status field
         * is unexpectedly missing from the submitted form.
         */
        $request->merge([
            'status' => (string) $request->input('status', '1'),
        ]);

        $validated = $request->validate(
            [
                'ebook_program_id' => [
                    'required',
                    'integer',
                    Rule::exists('ebook_programs', 'id'),
                ],

                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('ebook_folders', 'title')
                        ->where(fn ($query) => $query->where(
                            'ebook_program_id',
                            $request->input('ebook_program_id')
                        ))
                        ->ignore($ebookFolder?->id),
                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'drive_link' => [
                    'required',
                    'url',
                    'max:2048',
                ],

                'status' => [
                    'required',
                    Rule::in(['0', '1']),
                ],
            ],
            [
                'ebook_program_id.required' =>
                    'Please select an academic program.',

                'ebook_program_id.integer' =>
                    'The selected academic program is invalid.',

                'ebook_program_id.exists' =>
                    'The selected academic program does not exist.',

                'title.required' =>
                    'Please enter the folder name.',

                'title.max' =>
                    'The folder name must not exceed 255 characters.',

                'title.unique' =>
                    'This folder name already exists for the selected program.',

                'drive_link.required' =>
                    'Please enter the Google Drive folder link.',

                'drive_link.url' =>
                    'Please enter a valid Google Drive folder URL.',

                'drive_link.max' =>
                    'The Google Drive link is too long.',

                'status.required' =>
                    'Please select a folder status.',

                'status.in' =>
                    'The selected folder status is invalid.',
            ]
        );

        return [
            'ebook_program_id' =>
                (int) $validated['ebook_program_id'],

            'title' =>
                trim($validated['title']),

            'description' =>
                filled($validated['description'] ?? null)
                    ? trim($validated['description'])
                    : null,

            'drive_link' =>
                trim($validated['drive_link']),

            'status' =>
                (int) $validated['status'],
        ];
    }
}
