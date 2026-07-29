<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class DatabaseMedia
{
    public static function store(UploadedFile $file): string
    {
        $contents = file_get_contents($file->getRealPath());
        if ($contents === false || $contents === '') {
            return '';
        }

        $optimized = self::optimizeToWebp($contents);

        return 'data:image/webp;base64,' . base64_encode($optimized);
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

    private static function optimizeToWebp(string $contents): string
    {
        $source = @imagecreatefromstring($contents);

        if ($source === false) {
            return $contents;
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);

        $maxSize = 1600;
        $scale = min(
            1,
            $maxSize / max(1, $sourceWidth),
            $maxSize / max(1, $sourceHeight)
        );

        $targetWidth = (int) max(1, round($sourceWidth * $scale));
        $targetHeight = (int) max(1, round($sourceHeight * $scale));

        $target = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($target, false);
        imagesavealpha($target, true);

        $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
        imagefilledrectangle($target, 0, 0, $targetWidth, $targetHeight, $transparent);

        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight
        );

        ob_start();
        imagewebp($target, null, 82);
        $webpContents = ob_get_clean();

        imagedestroy($source);
        imagedestroy($target);

        return $webpContents !== false && $webpContents !== ''
            ? $webpContents
            : $contents;
    }
}
