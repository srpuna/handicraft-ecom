<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled in cache
        if (Cache::get('maintenance_mode')) {
            // Allow login, logout, and internal routes
            if ($request->is('login') || $request->is('logout') || $request->is('sanctum/*')) {
                return $next($request);
            }

            // If route is admin area, allow based on role and intent:
            if ($request->is('admin*')) {
                // Allow full admin users to continue working
                if (auth()->check() && (auth()->user()->is_admin || auth()->user()->isSuperAdmin())) {
                    return $next($request);
                }

                // Allow pure viewers read-only access to specific admin pages
                if (auth()->check() && auth()->user()->hasRole('viewer') && !auth()->user()->hasAnyRole(['admin', 'editor', 'super_admin'])) {
                    // Only allow safe methods
                    if (in_array($request->method(), ['GET', 'HEAD'])) {
                        // Restrict viewer access to the dashboard and inquiries listing/details
                        if ($request->is('admin') || $request->is('admin/') || $request->is('admin/inquiries*')) {
                            return $next($request);
                        }
                    }
                }

                // Otherwise block access to admin routes during maintenance
                return response()->view('maintenance', [], 503);
            }

            // Non-admin routes: show maintenance
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
