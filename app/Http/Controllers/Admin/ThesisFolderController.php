<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThesisFolder;
use App\Models\ThesisProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ThesisFolderController extends Controller
{
    /**
     * Display all thesis/dissertation folders alphabetically.
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

        $programs = ThesisProgram::query()
            ->orderBy('title', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Thesis/Dissertation folders sorted alphabetically
        |--------------------------------------------------------------------------
        */

        $folders = ThesisFolder::query()
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
                        'thesis_program_id',
                        $programId
                    );
                }
            )
            ->orderBy('title', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.theses.folders.index',
            compact('folders', 'programs')
        );
    }

    /**
     * Show the folder creation form.
     */
    public function create(Request $request): View
    {
        $programs = ThesisProgram::query()
            ->orderBy('title', 'asc')
            ->get();

        $selectedProgramId = $request->input('program');

        return view(
            'admin.theses.folders.create',
            compact('programs', 'selectedProgramId')
        );
    }

    /**
     * Store a newly created folder.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateAndPrepareFolder($request);

        ThesisFolder::create($data);

        return redirect()
            ->route('admin.thesis-folders.index')
            ->with(
                'success',
                'Thesis and dissertation folder created successfully.'
            );
    }

    /**
     * Show the folder editing form.
     */
    public function edit(ThesisFolder $thesisFolder): View
    {
        $programs = ThesisProgram::query()
            ->orderBy('title', 'asc')
            ->get();

        return view(
            'admin.theses.folders.edit',
            compact('thesisFolder', 'programs')
        );
    }

    /**
     * Update an existing folder.
     */
    public function update(
        Request $request,
        ThesisFolder $thesisFolder
    ): RedirectResponse {
        $data = $this->validateAndPrepareFolder($request, $thesisFolder);

        $thesisFolder->update($data);

        return redirect()
            ->route('admin.thesis-folders.index')
            ->with(
                'success',
                'Thesis and dissertation folder updated successfully.'
            );
    }

    /**
     * Delete the specified folder.
     */
    public function destroy(
        ThesisFolder $thesisFolder
    ): RedirectResponse {
        $thesisFolder->delete();

        return redirect()
            ->route('admin.thesis-folders.index')
            ->with(
                'success',
                'Thesis and dissertation folder deleted successfully.'
            );
    }

    /**
     * Validate and prepare folder information.
     */
    private function validateAndPrepareFolder(
        Request $request,
        ?ThesisFolder $thesisFolder = null
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
                'thesis_program_id' => [
                    'required',
                    'integer',
                    Rule::exists('thesis_programs', 'id'),
                ],

                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('thesis_folders', 'title')
                        ->where(fn ($query) => $query->where(
                            'thesis_program_id',
                            $request->input('thesis_program_id')
                        ))
                        ->ignore($thesisFolder?->id),
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
                'thesis_program_id.required' =>
                    'Please select an academic program.',

                'thesis_program_id.integer' =>
                    'The selected academic program is invalid.',

                'thesis_program_id.exists' =>
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
            'thesis_program_id' =>
                (int) $validated['thesis_program_id'],

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
