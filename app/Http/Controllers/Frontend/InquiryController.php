<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Product;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'product_id' => 'required|exists:products,id',
            'message' => 'required'
        ]);

        Inquiry::create($request->all());

        return back()->with('success', 'Your inquiry has been sent! We will contact you shortly.');
    }
}
