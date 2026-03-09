<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

if (! function_exists('media_disk')) {
    /**
     * Return the disk name to use for all media/product/logo uploads.
     */
    function media_disk(): string
    {
        // Fallback to 'public' if FILESYSTEM_DISK is 'local' or not set.
        $default = config('filesystems.default', 'local');
        return ($default === 'local' || $default === 'public') ? 'public' : $default;
    }
}

if (! function_exists('media_url')) {
    /**
     * Generate a fully-qualified public URL for a media file.
     */
    function media_url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // Return as-is if it's already a full URL (legacy records).
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        try {
            $diskName = media_disk();
            return Storage::disk($diskName)->url($path);
        } catch (\Throwable $e) {
            // Log the error but don't crash the site (returns local path for fallback).
            Log::error("Media URL generation failed: " . $e->getMessage());
            return asset('storage/' . $path);
        }
    }
}
