<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodicalFolder;
use App\Models\PeriodicalProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PeriodicalFolderController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $programId = $request->input('program');
        $programs = PeriodicalProgram::query()->orderBy('title')->get();

        $folders = PeriodicalFolder::query()
            ->with('program')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('folder_link', 'like', "%{$search}%")
                        ->orWhereHas('program', fn ($programQuery) => $programQuery->where('title', 'like', "%{$search}%"));
                });
            })
            ->when(filled($programId), fn ($query) => $query->where('periodical_program_id', $programId))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('admin.periodicals.folders.index', compact('folders', 'programs'));
    }

    public function create(Request $request): View
    {
        $programs = PeriodicalProgram::query()->orderBy('title')->get();
        $selectedProgramId = $request->input('program');
        return view('admin.periodicals.folders.create', compact('programs', 'selectedProgramId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateAndPrepareFolder($request);
        PeriodicalFolder::create($data);
        return redirect()->route('admin.periodical-folders.index')->with('success', 'Periodical folder created successfully.');
    }

    public function edit(PeriodicalFolder $periodicalFolder): View
    {
        $programs = PeriodicalProgram::query()->orderBy('title')->get();
        return view('admin.periodicals.folders.edit', compact('periodicalFolder', 'programs'));
    }

    public function update(Request $request, PeriodicalFolder $periodicalFolder): RedirectResponse
    {
        $data = $this->validateAndPrepareFolder($request, $periodicalFolder);
        $periodicalFolder->update($data);
        return redirect()->route('admin.periodical-folders.index')->with('success', 'Periodical folder updated successfully.');
    }

    public function destroy(PeriodicalFolder $periodicalFolder): RedirectResponse
    {
        $periodicalFolder->delete();
        return redirect()->route('admin.periodical-folders.index')->with('success', 'Periodical folder deleted successfully.');
    }

    private function validateAndPrepareFolder(Request $request, ?PeriodicalFolder $periodicalFolder = null): array
    {
        $request->merge(['status' => (string) $request->input('status', '1')]);
        $validated = $request->validate([
            'periodical_program_id' => ['required', 'integer', Rule::exists('periodical_programs', 'id')],
            'title' => ['required', 'string', 'max:255', Rule::unique('periodical_folders', 'title')->where(fn ($query) => $query->where('periodical_program_id', $request->input('periodical_program_id')))->ignore($periodicalFolder?->id)],
            'description' => ['nullable', 'string'],
            'folder_link' => ['required', 'url', 'max:2048'],
            'status' => ['required', Rule::in(['0','1'])],
        ], [
            'periodical_program_id.required' => 'Please select a program.',
            'title.unique' => 'This folder name already exists for the selected program.',
            'folder_link.required' => 'Please enter the folder link.',
            'folder_link.url' => 'Please enter a valid folder URL.',
        ]);

        return [
            'periodical_program_id' => (int) $validated['periodical_program_id'],
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
            'folder_link' => trim($validated['folder_link']),
            'status' => (int) $validated['status'],
        ];
    }
}
