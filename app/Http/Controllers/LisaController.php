<?php

namespace App\Http\Controllers;

use App\Services\LisaAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LisaController extends Controller
{
    private const MAX_ATTEMPTS = 20;

    private const DECAY_SECONDS = 60;

    public function message(Request $request, LisaAssistant $assistant): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:800'],
            'history' => ['nullable', 'array', 'max:12'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.text' => ['required_with:history', 'string', 'max:1500'],
        ]);

        $rateKey = 'lisa:'.$request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($rateKey);

            return response()->json([
                'message' => "Lisa is receiving too many requests. Please try again in {$seconds} seconds.",
            ], 429);
        }

        RateLimiter::hit($rateKey, self::DECAY_SECONDS);

        $history = collect($validated['history'] ?? [])
            ->filter(fn ($entry) => isset($entry['role'], $entry['text']) && filled($entry['text']))
            ->map(fn ($entry) => [
                'role' => $entry['role'],
                'text' => Str::limit(trim($entry['text']), 1500, ''),
            ])
            ->take(-10)
            ->values()
            ->all();

        $message = trim($validated['message']);
        $reply = $assistant->reply($message, $history);

        if ($this->looksSuspicious($message)) {
            Log::warning('Suspicious Lisa request', [
                'ip' => $request->ip(),
                'url' => $request->path(),
                'user_agent' => Str::limit((string) $request->userAgent(), 160, ''),
                'message' => Str::limit($message, 160, ''),
            ]);
        }

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

    private function looksSuspicious(string $message): bool
    {
        return Str::contains(Str::lower($message), [
            'ignore your previous instructions',
            'reveal your system prompt',
            'show me the database password',
            'execute this command',
            'sql query',
            'php code',
            'shell command',
            '.env',
            'api key',
        ]);
    }
}
