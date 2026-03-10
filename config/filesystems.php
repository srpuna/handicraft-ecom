<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    | Storage strategy (controlled by MEDIA_DISK / FILESYSTEM_DISK env vars):
    |
    | Localhost   → FILESYSTEM_DISK=local, MEDIA_DISK=public (defaults)
    |              Files go to storage/app/public/ and are served via storage:link.
    |              Do NOT set AWS_URL locally — it has no effect and can cause confusion.
    |              No AWS credentials needed. No production storage is touched.
    |
    | Production  → FILESYSTEM_DISK=s3, MEDIA_DISK=s3 (set in production env only)
    |              Files go to the S3/R2 bucket. AWS_* credentials set in production env.
    |              storage:link is not used.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    | On localhost (MEDIA_DISK=public), run `php artisan storage:link` once
    | so that files in storage/app/public/ are served via /storage/... URLs.
    | Production (MEDIA_DISK=s3) uses object storage directly — no symlink needed.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
