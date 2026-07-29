<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class DatabaseMedia
{
    public static function store(UploadedFile $file): string
    {
        $mimeType = $file->getMimeType() ?: $file->getClientMimeType() ?: 'application/octet-stream';
        $contents = file_get_contents($file->getRealPath());

        return 'data:' . $mimeType . ';base64,' . base64_encode($contents === false ? '' : $contents);
    }

    public static function isDataUri(?string $value): bool
    {
        return Str::startsWith((string) $value, 'data:');
    }
}
