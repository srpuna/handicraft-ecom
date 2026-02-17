<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class PageController extends Controller
{
    public function shippingPolicy()
    {
        $content = SiteSetting::get('shipping_policy', '');
        
        return view('frontend.pages.shipping-policy', compact('content'));
    }
}
