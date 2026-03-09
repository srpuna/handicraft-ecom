<?php

if (! function_exists('media_disk')) {
    /**
     * Return the disk name to use for all media/product/logo uploads.
     *
     * Resolution logic:
     *   FILESYSTEM_DISK=local  (localhost)  → 'public' disk (served via storage:link)
     *   FILESYSTEM_DISK=s3     (production) → 's3' disk (Laravel Cloud object storage)
     *
     * Never hardcode 's3' in upload/display code – always call media_disk() so that
     * local development continues to work without S3 credentials.
     */
    function media_disk(): string
    {
        $default = config('filesystems.default', 'local');

        // The 'local' disk is private; for media we want the public-facing disk.
        return $default === 'local' ? 'public' : $default;
    }
}

if (! function_exists('media_url')) {
    /**
     * Generate a fully-qualified public URL for a media file stored on the media disk.
     *
     * For 'public' disk  → {APP_URL}/storage/{path}   (localhost, requires storage:link)
     * For 's3' disk      → https://{bucket}.s3.{region}.amazonaws.com/{path}
     *
     * Usage in Blade: {{ media_url($product->main_image) }}
     *                 {{ media_url($setting->value) }}
     *
     * NOTE: If the stored value is already a full URL (legacy records that stored the
     * entire URL rather than the relative path), it is returned unchanged so that
     * existing product records continue to work after deployment.
     */
    function media_url(?string $path): string
    {
        if (! $path) {
            return '';
        }

        // If the value is already an absolute URL, return it as-is.
        // This handles legacy product records where the full S3 URL was stored.
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return \Illuminate\Support\Facades\Storage::disk(media_disk())->url($path);
    }
}
