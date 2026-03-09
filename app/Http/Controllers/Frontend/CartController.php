<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\ShippingZone;
use App\Services\ShippingService;

class CartController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    // Add to Cart (Session based for guests)
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        $cartItems = [];
        $subtotal = 0;

        foreach ($products as $product) {
            $qty = $cart[$product->id];
            $cartItems[] = [
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $product->effective_price * $qty
            ];
            $subtotal += ($product->effective_price * $qty);
        }

        return view('frontend.cart.index', compact('cartItems', 'subtotal'));
    }

    // Checkout Page (Handles both Cart and Inquiry Link)
    public function checkout($token = null)
    {
        $inquiry = null;
        $items = [];
        $subtotal = 0;

        if ($token) {
            // CheckOMS Order flow first
            $omsOrder = Order::where('checkout_token', $token)->where('type', 'inquiry')->first();

            if ($omsOrder) {
                // Return entirely different view or load items
                $omsOrder->load('items.product');
                foreach ($omsOrder->items as $item) {
                    $items[] = [
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->line_total
                    ];
                    $subtotal += $item->line_total;
                }
                $inquiry = $omsOrder; // Pass OMS order as inquiry variable for now
            } else {
                // Inquiry Checkout Flow (Legacy)
                $inquiry = Inquiry::where('checkout_token', $token)->firstOrFail();

                if ($inquiry->product) {
                    $qty = $inquiry->product->min_quantity ?? 1; // Default to min quantity or 1?
                    $items[] = [
                        'product' => $inquiry->product,
                        'quantity' => $qty,
                        'subtotal' => $inquiry->product->effective_price * $qty
                    ];
                    $subtotal += ($inquiry->product->effective_price * $qty);
                }
            }
        } else {
            // Standard Cart Flow
            $cart = session()->get('cart', []);
            if (empty($cart))
                return redirect()->route('home');

            $products = Product::whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $qty = $cart[$product->id];
                $items[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'subtotal' => $product->effective_price * $qty
                ];
                $subtotal += ($product->effective_price * $qty);
            }
        }

        // Build available countries options (value: raw from DB; label: friendly name)
        $rawCountries = ShippingZone::all()
            ->pluck('countries')
            ->flatten()
            ->filter()
            ->map(function ($c) {
                return is_string($c) ? $c : strval($c);
            })
            ->unique()
            ->values();

        $map = config('countries.map', []);
        $availableCountriesOptions = $rawCountries
            ->map(function ($raw) use ($map) {
                $upper = strtoupper(trim($raw));
                $label = $map[$upper] ?? ucwords(strtolower($raw));
                return ['value' => $raw, 'label' => $label];
            })
            ->sortBy('label')
            ->values()
            ->all();

        return view('frontend.cart.checkout', compact('items', 'subtotal', 'inquiry', 'token', 'availableCountriesOptions'));
    }

    // AJAX Shipping Calculation
    public function calculateShipping(Request $request)
    {
        $country = $request->country;
        $token = $request->token;

        // Reconstruct Items
        $items = [];
        if ($token) {
            $inquiry = Inquiry::where('checkout_token', $token)->first();
            if ($inquiry && $inquiry->product) {
                $items[] = ['product' => $inquiry->product, 'quantity' => $inquiry->product->min_quantity];
            }
        } else {
            $cart = session()->get('cart', []);
            $products = Product::whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $items[] = ['product' => $product, 'quantity' => $cart[$product->id]];
            }
        }

        if (empty($items)) {
            return response()->json(['error' => 'No items to calculate shipping for.'], 400);
        }

        $rates = $this->shippingService->calculateShipping($items, $country);

        return response()->json(['rates' => $rates]);
    }

    // Update cart quantity
    public function updateQuantity(Request $request)
    {
        $productId = $request->product_id;
        $quantity = max(1, (int) $request->quantity); // Ensure at least 1

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    // Remove item from cart
    public function removeItem(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }
}
