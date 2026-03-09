<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ViewerReadOnly
{
    /**
     * Allow users with only the `viewer` role to access read-only (GET/HEAD) admin pages.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        $user = Auth::user();

        if (!$user || !$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        // Apply viewer-only behavior only to users who are exclusively viewers
        if ($user->hasRole('viewer') && !$user->hasAnyRole(['admin', 'editor', 'super_admin'])) {
            // Allow safe methods to pass through as read-only
            if (in_array($request->method(), ['GET', 'HEAD'])) {
                // Mark request so permission middleware can short-circuit if needed
                $request->attributes->set('viewer_readonly', true);
                return $next($request);
            }

            // Block non-read-only actions for pure viewers
            abort(403, 'Unauthorized. Viewer accounts have read-only access.');
        }

        return $next($request);
    }
}
