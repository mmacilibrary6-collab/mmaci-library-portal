<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TrackVisitor
{
    private const IGNORED_PATHS = [
        'up',
        'favicon.ico',
        'robots.txt',
        'lisa/message',
    ];

    private const IGNORED_PREFIXES = [
        'admin',
        'storage',
        'build',
        'vendor',
        'css',
        'js',
        'fonts',
        'images',
        'favicon',
    ];

    private const IGNORED_EXTENSIONS = [
        'css', 'js', 'map', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'svg', 'ico',
        'woff', 'woff2', 'ttf', 'otf', 'eot', 'pdf', 'mp4', 'mp3', 'json',
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        $dedupeSeconds = max(5, (int) config('security.visitor_log_dedupe_seconds', 30));
        $cacheKey = $this->cacheKey($request, $response);

        if (! Cache::add($cacheKey, true, now()->addSeconds($dedupeSeconds))) {
            return $response;
        }

        try {
            VisitorLog::create([
                'ip_address' => (string) $request->ip(),
                'url' => Str::limit($this->fullUrl($request), 1024, ''),
                'method' => strtoupper($request->method()),
                'user_agent' => Str::limit((string) $request->userAgent(), 512, ''),
                'referrer' => Str::limit((string) $request->headers->get('referer'), 1024, ''),
                'user_id' => $request->user()?->id,
                'status_code' => method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
            ]);
        } catch (\Throwable) {
            // Never break page delivery because logging failed.
        }

        return $response;
    }

    protected function shouldTrack(Request $request, mixed $response): bool
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return false;
        }

        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return false;
        }

        if (! $this->isHtmlLikeResponse($response)) {
            return false;
        }

        $path = trim($request->path(), '/');
        $path = $path === '' ? '/' : $path;

        if (in_array($path, self::IGNORED_PATHS, true)) {
            return false;
        }

        if ($this->isIgnoredAssetPath($path)) {
            return false;
        }

        return true;
    }

    protected function isIgnoredAssetPath(string $path): bool
    {
        $firstSegment = Str::of($path)->explode('/')->first();
        if ($firstSegment !== null && in_array($firstSegment, self::IGNORED_PREFIXES, true)) {
            return true;
        }

        $extension = Str::lower(pathinfo($path, PATHINFO_EXTENSION));

        return $extension !== '' && in_array($extension, self::IGNORED_EXTENSIONS, true);
    }

    protected function fullUrl(Request $request): string
    {
        return $request->fullUrl();
    }

    protected function isHtmlLikeResponse(mixed $response): bool
    {
        $contentType = strtolower((string) ($response->headers->get('content-type') ?? ''));

        return $contentType === ''
            || str_contains($contentType, 'text/html')
            || str_contains($contentType, 'application/xhtml+xml');
    }

    protected function cacheKey(Request $request, mixed $response): string
    {
        return implode(':', [
            'visitor-log',
            sha1((string) $request->ip()),
            strtoupper($request->method()),
            sha1($this->fullUrl($request)),
            (string) ($response->getStatusCode() ?? '0'),
        ]);
    }
}
