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
        $category = $request->input('category');
        $programs = PeriodicalProgram::query()->orderBy('title')->get();
        $categories = PeriodicalFolder::query()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $folders = PeriodicalFolder::query()
            ->with('program')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('accession_number', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('folder_link', 'like', "%{$search}%")
                        ->orWhereHas('program', fn ($programQuery) => $programQuery->where('title', 'like', "%{$search}%"));
                });
            })
            ->when(filled($programId), fn ($query) => $query->where('periodical_program_id', $programId))
            ->when(filled($category), fn ($query) => $query->where('category', $category))
            ->orderBy('title', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.periodicals.folders.index', compact('folders', 'programs', 'categories'));
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
        $category = (string) $request->input('category');

        $accessionRules = ['nullable', 'string', 'max:100'];

        if ($category === 'journal_newspaper') {
            $accessionRules = [
                'required',
                'string',
                'max:100',
                Rule::unique('periodical_folders', 'accession_number')->ignore($periodicalFolder?->id),
            ];
        }

        $validated = $request->validate([
            'periodical_program_id' => ['required', 'integer', Rule::exists('periodical_programs', 'id')],
            'category' => ['required', Rule::in(['journal_newspaper', 'magazine'])],
            'accession_number' => $accessionRules,
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('periodical_folders', 'title')
                    ->where(fn ($query) => $query
                        ->where('periodical_program_id', $request->input('periodical_program_id'))
                        ->where('category', $request->input('category')))
                    ->ignore($periodicalFolder?->id),
            ],
            'description' => ['nullable', 'string'],
            'folder_link' => ['required', 'url', 'max:2048'],
            'status' => ['required', Rule::in(['0','1'])],
        ], [
            'periodical_program_id.required' => 'Please select a program.',
            'category.required' => 'Please select a category.',
            'accession_number.required' => 'Please enter an accession number for journal and newspaper clippings.',
            'accession_number.unique' => 'This accession number already exists.',
            'title.unique' => 'This folder name already exists for the selected program and category.',
            'folder_link.required' => 'Please enter the folder link.',
            'folder_link.url' => 'Please enter a valid folder URL.',
        ]);

        return [
            'periodical_program_id' => (int) $validated['periodical_program_id'],
            'category' => $validated['category'],
            'accession_number' => $validated['category'] === 'journal_newspaper'
                ? strtoupper(trim((string) $validated['accession_number']))
                : null,
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
            'folder_link' => trim($validated['folder_link']),
            'status' => (int) $validated['status'],
        ];
    }
}
