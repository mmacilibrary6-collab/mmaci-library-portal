<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUrl
{
    public static function resolve(?string $value, ?string $fallback = null): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return self::fallback($fallback);
        }

        if (Str::startsWith($value, ['data:', 'http://', 'https://'])) {
            return $value;
        }

        $normalized = MediaStorage::normalizePath($value);
        $publicPath = public_path($normalized);

        if (File::exists($publicPath)) {
            return asset($normalized);
        }

        if (MediaStorage::exists($normalized)) {
            return MediaStorage::url($normalized, self::fallback($fallback));
        }

        return self::fallback($fallback);
    }

    public static function fallback(?string $fallback = null): string
    {
        $fallback = trim((string) $fallback);

        if ($fallback !== '') {
            $normalized = MediaStorage::normalizePath($fallback);

            if (File::exists(public_path($normalized))) {
                return asset($normalized);
            }

            if (Storage::disk(config('filesystems.media_disk', 'public'))->exists($normalized)) {
                return MediaStorage::url($normalized);
            }
        }

        return self::placeholder();
    }

    public static function placeholder(string $label = 'Image unavailable'): string
    {
        $label = e($label);
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 640" role="img" aria-label="{$label}">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#0b2e59"/>
      <stop offset="100%" stop-color="#184b8c"/>
    </linearGradient>
    <linearGradient id="fg" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0%" stop-color="#f4b400"/>
      <stop offset="100%" stop-color="#ffd766"/>
    </linearGradient>
  </defs>
  <rect width="960" height="640" rx="34" fill="url(#bg)"/>
  <circle cx="748" cy="136" r="120" fill="rgba(244,180,0,0.12)"/>
  <circle cx="190" cy="532" r="150" fill="rgba(255,255,255,0.07)"/>
  <rect x="126" y="132" width="708" height="376" rx="28" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.16)" stroke-width="4"/>
  <path d="M225 412l132-142 94 104 68-70 120 108" fill="none" stroke="url(#fg)" stroke-width="18" stroke-linecap="round" stroke-linejoin="round"/>
  <circle cx="306" cy="268" r="28" fill="url(#fg)"/>
  <path d="M402 454h156" stroke="#ffffff" stroke-opacity=".75" stroke-width="18" stroke-linecap="round"/>
  <text x="480" y="562" text-anchor="middle" fill="#ffffff" font-family="Poppins, Arial, sans-serif" font-size="34" font-weight="700">MMACI Library</text>
</svg>
SVG;

        return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
    }
}
