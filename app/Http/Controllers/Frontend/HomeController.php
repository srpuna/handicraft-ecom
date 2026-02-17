<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get counts for filter tabs
        $newArrivalsCount = Product::where('is_new_arrival', true)->count();
        $featuredCount = Product::where('is_featured', true)->count();
        $recommendedCount = Product::where('is_recommended', true)->count();
        $onSaleCount = Product::where('is_on_sale', true)->whereNotNull('discount_price')->count();

        $query = Product::query();

        // Apply filter based on tab selection
        $filter = $request->get('filter');
        switch ($filter) {
            case 'new-arrivals':
                $query->where('is_new_arrival', true)->orderBy('carousel_priority', 'desc');
                break;
            case 'featured':
                $query->where('is_featured', true)->orderBy('carousel_priority', 'desc');
                break;
            case 'recommended':
                $query->where('is_recommended', true)->orderBy('carousel_priority', 'desc');
                break;
            case 'on-sale':
                $query->where('is_on_sale', true)->whereNotNull('discount_price')->orderBy('carousel_priority', 'desc');
                break;
            default:
                // All products - no special filter
                break;
        }

        // Filter by Category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by SubCategory
        if ($request->has('subcategory')) {
            $query->whereHas('subCategory', function ($q) use ($request) {
                $q->where('slug', $request->subcategory);
            });
        }

        // Filter by Search Term
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::with('subCategories')->withCount('products')->get();

        return view('frontend.home', compact(
            'products', 
            'categories',
            'newArrivalsCount',
            'featuredCount',
            'recommendedCount',
            'onSaleCount'
        ));
    }
}
