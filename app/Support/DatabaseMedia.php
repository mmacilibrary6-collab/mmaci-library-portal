<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class DatabaseMedia
{
    public static function store(UploadedFile $file): string
    {
        $path = $file->getRealPath();
        $imageInfo = @getimagesize($path);

        if ($imageInfo === false) {
            throw ValidationException::withMessages([
                'image_file' => 'The uploaded file is not a readable image.',
            ]);
        }

        [$width, $height] = $imageInfo;

        // GD expands compressed files into raw pixels. Keep the decoded image
        // comfortably below Laravel Cloud's 256 MB PHP memory limit.
        if ($width > 4096 || $height > 4096 || ($width * $height) > 8_000_000) {
            throw ValidationException::withMessages([
                'image_file' => 'The image is too large to process safely. Use an image no larger than 4,096 pixels per side and 8 megapixels total.',
            ]);
        }

        $optimized = self::optimizeToWebp($path, (string) ($imageInfo['mime'] ?? ''));

        return $optimized;
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

    private static function optimizeToWebp(string $path, string $mimeType): string
    {
        $source = match ($mimeType) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => @imagecreatefromwebp($path),
            default => false,
        };

        if ($source === false) {
            throw ValidationException::withMessages([
                'image_file' => 'The uploaded image could not be processed. Please use a valid JPG, PNG, or WEBP file.',
            ]);
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);

        // Keep uploaded images reasonably sized so they load faster and
        // produce smaller database-backed payloads.
        $maxSize = 1280;
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
        imagewebp($target, null, 76);
        $webpContents = ob_get_clean();

        imagedestroy($source);
        imagedestroy($target);

        if ($webpContents === false || $webpContents === '') {
            throw ValidationException::withMessages([
                'image_file' => 'The uploaded image could not be compressed. Please try another image.',
            ]);
        }

        return $webpContents;
    }

    public static function ensureBlobColumns(array $tableNames): void
    {
        foreach ($tableNames as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'image')) {
                continue;
            }

            DB::statement("ALTER TABLE `{$tableName}` MODIFY `image` LONGBLOB NULL");
        }
    }
}
