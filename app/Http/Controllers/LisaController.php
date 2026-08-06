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
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['nullable', 'array', 'max:12'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.text' => ['required_with:history', 'string', 'max:1500'],
        ]);

        $history = collect($data['history'] ?? [])
            ->filter(fn ($entry) => isset($entry['role'], $entry['text']))
            ->map(fn ($entry) => [
                'role' => $entry['role'],
                'text' => Str::limit(trim($entry['text']), 1500, ''),
            ])
            ->take(-10)
            ->values()
            ->all();

        return response()->json(
            $assistant->reply(trim($data['message']), $history)
        );
    }
}