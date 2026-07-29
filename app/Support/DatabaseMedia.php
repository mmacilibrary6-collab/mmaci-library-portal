<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class DatabaseMedia
{
    public static function store(UploadedFile $file): string
    {
        $contents = file_get_contents($file->getRealPath());

        return $contents === false ? '' : $contents;
    }

    public static function toDataUri(?string $value, string $fallback = ''): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return $fallback;
        }

        if (Str::startsWith($value, ['http://', 'https://', 'data:'])) {
            return $value;
        }

        $mimeType = self::detectMimeType($value);

        return 'data:' . $mimeType . ';base64,' . base64_encode($value);
    }

    private static function detectMimeType(string $value): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($value);

        return is_string($mimeType) && $mimeType !== ''
            ? $mimeType
            : 'application/octet-stream';
    }
}
