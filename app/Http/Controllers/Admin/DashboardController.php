<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalProducts = Schema::hasTable('products') ? Product::count() : 0;
            $totalCategories = Schema::hasTable('categories') ? Category::count() : 0;
            $totalInquiries = Schema::hasTable('inquiries') ? Inquiry::count() : 0;
        } catch (\Exception $e) {
            $totalProducts = 0;
            $totalCategories = 0;
            $totalInquiries = 0;
        }
        
        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalInquiries'));
    }

    public function toggleMaintenance(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        $current = Cache::get('maintenance_mode', false);
        if ($current) {
            Cache::forget('maintenance_mode');
            $message = 'Maintenance mode disabled. Site is live.';
        } else {
            Cache::forever('maintenance_mode', true);
            $message = 'Maintenance mode enabled. Site is hidden from public.';
        }

        return back()->with('success', $message);
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (Hash::check($request->password, auth()->user()->password)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Incorrect password.'], 401);
    }
}
