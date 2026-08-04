<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodicalProgram;
use App\Support\DatabaseMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PeriodicalProgramController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));

        $programs = PeriodicalProgram::query()
            ->withCount('folders')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('admin.periodicals.programs.index', compact('programs'));
    }

    public function create(): View
    {
        return view('admin.periodicals.programs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['periodical_programs']);
        $data = $this->validateAndPrepareProgram($request);
        PeriodicalProgram::create($data);
        return redirect()->route('admin.periodical-programs.index')->with('success', 'Periodical program created successfully.');
    }

    public function edit(PeriodicalProgram $periodicalProgram): View
    {
        return view('admin.periodicals.programs.edit', compact('periodicalProgram'));
    }

    public function update(Request $request, PeriodicalProgram $periodicalProgram): RedirectResponse
    {
        DatabaseMedia::ensureBlobColumns(['periodical_programs']);
        $data = $this->validateAndPrepareProgram($request, $periodicalProgram);
        $periodicalProgram->update($data);
        return redirect()->route('admin.periodical-programs.index')->with('success', 'Periodical program updated successfully.');
    }

    public function destroy(PeriodicalProgram $periodicalProgram): RedirectResponse
    {
        if ($periodicalProgram->folders()->exists()) {
            return redirect()->route('admin.periodical-programs.index')->with('error', 'This program cannot be deleted because it still has folders. Delete the folders first.');
        }
        $periodicalProgram->delete();
        return redirect()->route('admin.periodical-programs.index')->with('success', 'Periodical program deleted successfully.');
    }

    private function validateAndPrepareProgram(Request $request, ?PeriodicalProgram $periodicalProgram = null): array
    {
        $request->merge(['status' => (string) $request->input('status', '1')]);
        $validated = $request->validate([
            'category' => ['required', Rule::in(['journal_newspaper', 'magazine'])],
            'title' => ['required', 'string', 'max:255', Rule::unique('periodical_programs', 'title')->ignore($periodicalProgram?->id)],
            'description' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', Rule::in(['0','1'])],
        ]);

        $data = [
            'category' => $validated['category'],
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
            'status' => (int) $validated['status'],
        ];

        if ($request->hasFile('image_file')) {
            $data['image'] = DatabaseMedia::store($request->file('image_file'));
        } elseif (filled($validated['image_url'] ?? null)) {
            $data['image'] = trim($validated['image_url']);
        } elseif (!$periodicalProgram) {
            $data['image'] = null;
        }

        return $data;
    }
}
