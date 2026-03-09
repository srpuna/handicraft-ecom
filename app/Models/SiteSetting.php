<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value, string $type = 'text', string $group = 'general')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );

        Cache::forget("setting_{$key}");
        return $setting;
    }

    /**
     * Get all settings as key-value pairs
     */
    public static function getAll()
    {
        return Cache::rememberForever('all_settings', function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group)
    {
        return self::where('group', $group)->get();
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::forget('all_settings');
        self::all()->each(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });
    }

    /**
     * Get logo URL — works on both localhost ('public' disk) and
     * Laravel Cloud ('s3' disk) via the media_disk() helper.
     */
    public function getLogoUrl(): ?string
    {
        if (! $this->value) {
            return null;
        }

        // We use rescue to prevent any S3 initialization error from crashing the site
        return rescue(function() {
            if (filter_var($this->value, FILTER_VALIDATE_URL)) {
                return $this->value;
            }
            $disk = Product::mediaDisk();
            return \Illuminate\Support\Facades\Storage::disk($disk)->url($this->value);
        }, fn() => asset('storage/' . $this->value));
    }
}
