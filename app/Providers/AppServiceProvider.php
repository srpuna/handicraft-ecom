<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share site settings with all views (with error handling for migrations)
        View::composer('*', function ($view) {
            try {
                // Check if the site_settings table exists before querying
                if (Schema::hasTable('site_settings')) {
                    $view->with('siteSettings', [
                        'site_name' => SiteSetting::get('site_name', 'LuxeStore'),
                        'navbar_logo' => SiteSetting::where('key', 'navbar_logo')->first(),
                        'footer_logo' => SiteSetting::where('key', 'footer_logo')->first(),
                        'favicon' => SiteSetting::where('key', 'favicon')->first(),
                        'footer_qr_code' => SiteSetting::where('key', 'footer_qr_code')->first(),
                        'whatsapp_number' => SiteSetting::get('whatsapp_number', ''),
                        'footer_address' => SiteSetting::get('footer_address', ''),
                        'footer_phone' => SiteSetting::get('footer_phone', ''),
                        'footer_email' => SiteSetting::get('footer_email', ''),
                        'footer_hours' => SiteSetting::get('footer_hours', ''),
                    ]);
                } else {
                    // Provide default values if table doesn't exist
                    $view->with('siteSettings', [
                        'site_name' => 'LuxeStore',
                        'navbar_logo' => null,
                        'footer_logo' => null,
                        'favicon' => null,
                        'footer_qr_code' => null,
                        'whatsapp_number' => '',
                        'footer_address' => '',
                        'footer_phone' => '',
                        'footer_email' => '',
                        'footer_hours' => '',
                    ]);
                }
            } catch (\Exception $e) {
                // Fallback to defaults if any database error occurs
                $view->with('siteSettings', [
                    'site_name' => 'LuxeStore',
                    'navbar_logo' => null,
                    'footer_logo' => null,
                    'favicon' => null,
                    'footer_qr_code' => null,
                    'whatsapp_number' => '',
                    'footer_address' => '',
                    'footer_phone' => '',
                    'footer_email' => '',
                    'footer_hours' => '',
                ]);
            }
        });
    }
}
