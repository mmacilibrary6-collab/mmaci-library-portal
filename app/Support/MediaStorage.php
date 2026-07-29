<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaStorage
{
    public static function disk()
    {
        return Storage::disk(config('filesystems.media_disk', 'public'));
    }

    public static function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, config('filesystems.media_disk', 'public'));
    }

    public static function url(?string $path, string $fallback = ''): string
    {
        $path = self::normalizePath($path);

        if ($path === '') {
            return $fallback;
        }

        if (Str::startsWith($path, 'data:')) {
            return $path;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $diskName = config('filesystems.media_disk', 'public');

        if ($diskName === 'public') {
            return route('public.media', ['path' => $path]);
        }

        return Storage::disk($diskName)->url($path);
    }

    public static function delete(?string $path): void
    {
        $path = self::normalizePath($path);

        if ($path === '' || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        self::disk()->delete($path);
    }

    public static function exists(?string $path): bool
    {
        $path = self::normalizePath($path);

        return $path !== '' && self::disk()->exists($path);
    }

    public static function normalizePath(?string $path): string
    {
        $path = trim((string) $path);
        $path = str_replace('\\', '/', $path);

        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }

        return ltrim($path, '/');
    }
}
