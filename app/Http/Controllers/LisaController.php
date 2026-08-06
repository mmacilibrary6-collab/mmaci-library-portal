<?php

namespace App\Http\Controllers;

use App\Services\LisaAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LisaController extends Controller
{
    public function message(Request $request, LisaAssistant $assistant): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['nullable', 'array', 'max:12'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.text' => ['required_with:history', 'string', 'max:1500'],
        ]);

        $history = collect($validated['history'] ?? [])
            ->filter(fn ($entry) => isset($entry['role'], $entry['text']) && filled($entry['text']))
            ->map(fn ($entry) => [
                'role' => $entry['role'],
                'text' => Str::limit(trim($entry['text']), 1500, ''),
            ])
            ->take(-10)
            ->values()
            ->all();

        $reply = $assistant->reply(trim($validated['message']), $history);

        return response()->json([
            'answer' => $reply['answer'] ?? 'Sorry, I could not find a suitable answer right now.',
            'title' => $reply['title'] ?? null,
            'pageUrl' => $reply['pageUrl'] ?? null,
            'suggestions' => collect($reply['suggestions'] ?? [])
                ->map(fn ($item) => trim((string) $item))
                ->filter()
                ->unique(fn ($item) => Str::lower($item))
                ->take(4)
                ->values()
                ->all(),
        ]);
    }
}