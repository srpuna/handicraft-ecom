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
    | The 'media' disk is the single abstraction used for all product/media
    | uploads. On localhost it resolves to 'public' (local storage with
    | storage:link). On Laravel Cloud it resolves to 's3' (object storage).
    | Set MEDIA_DISK=public on localhost and MEDIA_DISK=s3 in production.
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
            'key' => env('AWS_ACCESS_KEY_ID') ?: env('S3_KEY') ?: env('BUCKET_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY') ?: env('S3_SECRET') ?: env('BUCKET_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION') ?: env('S3_REGION') ?: env('BUCKET_REGION', 'us-east-1'),
            'bucket' => env('AWS_BUCKET') ?: env('S3_BUCKET') ?: env('BUCKET_NAME'),
            'url' => env('AWS_URL') ?: env('S3_URL') ?: env('BUCKET_URL'),
            'endpoint' => env('AWS_ENDPOINT') ?: env('S3_ENDPOINT') ?: env('BUCKET_ENDPOINT'),
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
    | Note: storage:link is only required on localhost. Laravel Cloud uses
    | object storage (S3) directly, so no symlink is needed there.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
