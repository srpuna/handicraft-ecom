<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Client;
use App\Models\Order;
use App\Services\OrderService;

class InquiryController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Find or create client
        $client = Client::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'buyer_id' => Client::generateBuyerId(),
            ]
        );

        // Prepare order data
        $orderData = [
            'type' => Order::TYPE_INQUIRY,
            'client_id' => $client->id,
            'notes' => $request->message,
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'unit_price' => $product->effective_price ?? $product->price,
                    'weight_kg' => $product->weight,
                ]
            ]
        ];

        // Create the unified Inquiry (Order record)
        $this->orderService->createOrder($orderData, null);

        return back()->with('success', 'Your inquiry has been sent! We will contact you shortly.');
    }
}
