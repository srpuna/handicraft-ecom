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
                    $navbarLogo    = SiteSetting::where('key', 'navbar_logo')->first();
                    $footerLogo    = SiteSetting::where('key', 'footer_logo')->first();
                    $favicon       = SiteSetting::where('key', 'favicon')->first();
                    $footerQrCode  = SiteSetting::where('key', 'footer_qr_code')->first();

                    $view->with('siteSettings', [
                        'site_name'         => SiteSetting::get('site_name', 'LuxeStore'),
                        // Model objects (needed by admin settings page for editing)
                        'navbar_logo'       => $navbarLogo,
                        'footer_logo'       => $footerLogo,
                        'favicon'           => $favicon,
                        'footer_qr_code'    => $footerQrCode,
                        // Pre-resolved URLs — use these in display views instead of asset('storage/...')
                        'navbar_logo_url'   => $navbarLogo?->getLogoUrl(),
                        'footer_logo_url'   => $footerLogo?->getLogoUrl(),
                        'favicon_url'       => $favicon?->getLogoUrl(),
                        'footer_qr_code_url' => $footerQrCode?->getLogoUrl(),
                        'whatsapp_number'   => SiteSetting::get('whatsapp_number', ''),
                        'footer_address'    => SiteSetting::get('footer_address', ''),
                        'footer_phone'      => SiteSetting::get('footer_phone', ''),
                        'footer_email'      => SiteSetting::get('footer_email', ''),
                        'footer_hours'      => SiteSetting::get('footer_hours', ''),
                    ]);
                } else {
                    // Provide default values if table doesn't exist
                    $view->with('siteSettings', [
                        'site_name'          => 'LuxeStore',
                        'navbar_logo'        => null,
                        'footer_logo'        => null,
                        'favicon'            => null,
                        'footer_qr_code'     => null,
                        'navbar_logo_url'    => null,
                        'footer_logo_url'    => null,
                        'favicon_url'        => null,
                        'footer_qr_code_url' => null,
                        'whatsapp_number'    => '',
                        'footer_address'     => '',
                        'footer_phone'       => '',
                        'footer_email'       => '',
                        'footer_hours'       => '',
                    ]);
                }
            } catch (\Throwable $e) {
                // Fallback to defaults if any database or logic error occurs
                $view->with('siteSettings', [
                    'site_name'          => 'LuxeStore',
                    'navbar_logo'        => null,
                    'footer_logo'        => null,
                    'favicon'            => null,
                    'footer_qr_code'     => null,
                    'navbar_logo_url'    => null,
                    'footer_logo_url'    => null,
                    'favicon_url'        => null,
                    'footer_qr_code_url' => null,
                    'whatsapp_number'    => '',
                    'footer_address'     => '',
                    'footer_phone'       => '',
                    'footer_email'       => '',
                    'footer_hours'       => '',
                ]);
            }
        });
    }
}
