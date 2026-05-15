<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingZone;
use App\Services\OrderService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    protected $shippingService;
    protected $orderService;

    public function __construct(ShippingService $shippingService, OrderService $orderService)
    {
        $this->shippingService = $shippingService;
        $this->orderService = $orderService;
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'purchase_type' => ['nullable', Rule::in([Product::PURCHASE_TYPE_NORMAL, Product::PURCHASE_TYPE_SALE])],
            'spiritual_option' => ['nullable', Rule::in(array_keys(Product::SPIRITUAL_OPTION_LABELS))],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $quantity = max((int) ($validated['quantity'] ?? 1), (int) ($product->min_quantity ?? 1));
        $validated['purchase_type'] = $validated['purchase_type'] ?? Product::PURCHASE_TYPE_NORMAL;

        if ($validated['purchase_type'] === Product::PURCHASE_TYPE_SALE && !$product->hasSalePrice()) {
            return back()->withErrors(['purchase_type' => 'Sale pricing is not available for this product.'])->withInput();
        }

        $spiritualOption = $validated['spiritual_option'] ?? null;
        if (!$product->has_spiritual_options) {
            $spiritualOption = null;
        }

        $optionPrice = $product->getSpiritualOptionPrice($spiritualOption);
        $lineKey = $this->makeCartLineKey($product->id, $validated['purchase_type'], $spiritualOption);
        $cart = $this->getCartLines();

        if (isset($cart[$lineKey])) {
            $cart[$lineKey]['quantity'] += $quantity;
        } else {
            $cart[$lineKey] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'purchase_type' => $validated['purchase_type'],
                'spiritual_option' => $spiritualOption,
                'option_price' => round($optionPrice, 2),
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cartItems = $this->buildSessionCartItems();
        $subtotal = collect($cartItems)->sum('subtotal');

        return view('frontend.cart.index', compact('cartItems', 'subtotal'));
    }

    public function checkout($token = null)
    {
        $inquiry = null;
        $items = [];
        $subtotal = 0;

        if ($token) {
            $omsOrder = Order::where('checkout_token', $token)->where('type', 'inquiry')->first();

            if ($omsOrder) {
                $omsOrder->load('items.product');
                foreach ($omsOrder->items as $item) {
                    $items[] = [
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                        'purchase_type' => $item->purchase_type,
                        'purchase_type_label' => $item->purchase_type_label,
                        'spiritual_option' => $item->spiritual_option,
                        'spiritual_option_label' => $item->spiritual_option_label,
                        'option_price' => (float) $item->option_price,
                        'unit_price' => (float) $item->unit_price,
                        'base_unit_price' => (float) $item->base_unit_price,
                        'subtotal' => (float) $item->line_total,
                    ];
                    $subtotal += (float) $item->line_total;
                }
                $inquiry = $omsOrder;
            } else {
                $inquiry = Inquiry::where('checkout_token', $token)->firstOrFail();

                if ($inquiry->product) {
                    $qty = $inquiry->product->min_quantity ?? 1;
                    $unitPrice = (float) $inquiry->product->effective_price;
                    $items[] = [
                        'product' => $inquiry->product,
                        'quantity' => $qty,
                        'purchase_type' => Product::PURCHASE_TYPE_NORMAL,
                        'purchase_type_label' => 'Normal',
                        'spiritual_option' => null,
                        'spiritual_option_label' => null,
                        'option_price' => 0.0,
                        'unit_price' => $unitPrice,
                        'base_unit_price' => $unitPrice,
                        'subtotal' => $unitPrice * $qty,
                    ];
                    $subtotal += ($unitPrice * $qty);
                }
            }
        } else {
            $items = $this->buildSessionCartItems();
            if (empty($items)) {
                return redirect()->route('home');
            }
            $subtotal = collect($items)->sum('subtotal');
        }

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

    public function calculateShipping(Request $request)
    {
        $country = $request->country;
        $token = $request->token;

        $items = [];
        if ($token) {
            $omsOrder = Order::where('checkout_token', $token)->where('type', 'inquiry')->first();
            if ($omsOrder) {
                $omsOrder->load('items.product');
                foreach ($omsOrder->items as $item) {
                    if ($item->product) {
                        $items[] = ['product' => $item->product, 'quantity' => $item->quantity];
                    }
                }
            } else {
                $inquiry = Inquiry::where('checkout_token', $token)->first();
                if ($inquiry && $inquiry->product) {
                    $items[] = ['product' => $inquiry->product, 'quantity' => $inquiry->product->min_quantity];
                }
            }
        } else {
            foreach ($this->buildSessionCartItems() as $item) {
                $items[] = ['product' => $item['product'], 'quantity' => $item['quantity']];
            }
        }

        if (empty($items)) {
            return response()->json(['error' => 'No items to calculate shipping for.'], 400);
        }

        $rates = $this->shippingService->calculateShipping($items, $country);

        return response()->json(['rates' => $rates]);
    }

    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'line_key' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCartLines();
        $line = $cart[$validated['line_key']] ?? null;

        if ($line) {
            $product = Product::find($line['product_id']);
            $minQuantity = $product?->min_quantity ?? 1;
            $cart[$validated['line_key']]['quantity'] = max($minQuantity, (int) $validated['quantity']);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function removeItem(Request $request)
    {
        $validated = $request->validate([
            'line_key' => ['required', 'string'],
        ]);

        $cart = $this->getCartLines();

        if (isset($cart[$validated['line_key']])) {
            unset($cart[$validated['line_key']]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function initOrder(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:10'],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'token' => ['nullable', 'string'],
        ]);

        $token = $validated['token'] ?? null;
        $items = [];

        if ($token) {
            $omsOrder = Order::where('checkout_token', $token)->where('type', 'inquiry')->first();

            if ($omsOrder) {
                $omsOrder->load('items.product');
                foreach ($omsOrder->items as $item) {
                    $items[] = [
                        'product_id' => $item->product_id,
                        'purchase_type' => $item->purchase_type,
                        'spiritual_option' => $item->spiritual_option,
                        'option_price' => $item->option_price,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'weight_kg' => $item->weight_kg ?? ($item->product?->weight ?? 0),
                        'item_discount_type' => $item->item_discount_type ?? 'none',
                        'item_discount_value' => $item->item_discount_value ?? 0,
                    ];
                }

                $omsOrder->checkout_token = null;
                $omsOrder->save();
            } else {
                $inquiry = Inquiry::where('checkout_token', $token)->first();
                if ($inquiry && $inquiry->product) {
                    $product = $inquiry->product;
                    $qty = $product->min_quantity ?? 1;
                    $unitPrice = (float) $product->effective_price;
                    $items[] = [
                        'product_id' => $product->id,
                        'purchase_type' => Product::PURCHASE_TYPE_NORMAL,
                        'spiritual_option' => null,
                        'option_price' => 0,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'weight_kg' => $product->weight ?? 0,
                        'item_discount_type' => 'none',
                        'item_discount_value' => 0,
                    ];
                }
            }
        } else {
            foreach ($this->getCartLines() as $line) {
                $product = Product::find($line['product_id']);
                if (!$product) {
                    continue;
                }

                $purchaseType = $line['purchase_type'] ?? Product::PURCHASE_TYPE_NORMAL;
                $spiritualOption = $product->has_spiritual_options ? ($line['spiritual_option'] ?? null) : null;
                $optionPrice = $product->has_spiritual_options
                    ? $product->getSpiritualOptionPrice($spiritualOption)
                    : 0;
                $unitPrice = $product->getPurchasePrice($purchaseType) + $optionPrice;

                $items[] = [
                    'product_id' => $product->id,
                    'purchase_type' => $purchaseType,
                    'spiritual_option' => $spiritualOption,
                    'option_price' => $optionPrice,
                    'quantity' => $line['quantity'],
                    'unit_price' => $unitPrice,
                    'weight_kg' => $product->weight ?? 0,
                    'item_discount_type' => 'none',
                    'item_discount_value' => 0,
                ];
            }
        }

        if (empty($items)) {
            return response()->json(['error' => 'No items found for this order.'], 422);
        }

        $client = Client::where('email', $validated['email'])->first();

        if (!$client) {
            $client = Client::create([
                'buyer_id' => Client::generateBuyerId(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address_line' => $validated['address'],
                'city' => $validated['city'],
                'zip_code' => $validated['zip_code'] ?? null,
                'country' => $validated['country'],
            ]);
        }

        $order = $this->orderService->createOrder([
            'type' => Order::TYPE_ORDER,
            'client_id' => $client->id,
            'shipping_cost' => $validated['shipping_cost'],
            'items' => $items,
        ]);

        return response()->json([
            'order_id' => $order->id,
            'grand_total' => number_format((float) $order->grand_total, 2, '.', ''),
        ]);
    }

    public function orderSuccess(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('is_paid', true)
            ->with(['client', 'items.product'])
            ->firstOrFail();

        return view('frontend.cart.order-success', compact('order'));
    }

    protected function getCartLines(): array
    {
        $cart = session()->get('cart', []);
        $normalized = [];

        foreach ($cart as $key => $line) {
            if (is_numeric($line)) {
                $productId = (int) $key;
                $normalized[$this->makeCartLineKey($productId, Product::PURCHASE_TYPE_NORMAL, null)] = [
                    'product_id' => $productId,
                    'quantity' => (int) $line,
                    'purchase_type' => Product::PURCHASE_TYPE_NORMAL,
                    'spiritual_option' => null,
                    'option_price' => 0,
                ];
                continue;
            }

            if (!is_array($line) || empty($line['product_id'])) {
                continue;
            }

            $purchaseType = $line['purchase_type'] ?? Product::PURCHASE_TYPE_NORMAL;
            $spiritualOption = $line['spiritual_option'] ?? null;
            $normalized[$key] = [
                'product_id' => (int) $line['product_id'],
                'quantity' => max(1, (int) ($line['quantity'] ?? 1)),
                'purchase_type' => in_array($purchaseType, [Product::PURCHASE_TYPE_NORMAL, Product::PURCHASE_TYPE_SALE], true)
                    ? $purchaseType
                    : Product::PURCHASE_TYPE_NORMAL,
                'spiritual_option' => $spiritualOption,
                'option_price' => round((float) ($line['option_price'] ?? 0), 2),
            ];
        }

        return $normalized;
    }

    protected function buildSessionCartItems(): array
    {
        $cart = $this->getCartLines();
        $products = Product::whereIn('id', collect($cart)->pluck('product_id')->unique()->all())->get()->keyBy('id');

        $items = [];
        foreach ($cart as $lineKey => $line) {
            $product = $products[$line['product_id']] ?? null;
            if (!$product) {
                continue;
            }

            $purchaseType = $line['purchase_type'] ?? Product::PURCHASE_TYPE_NORMAL;
            if ($purchaseType === Product::PURCHASE_TYPE_SALE && !$product->hasSalePrice()) {
                $purchaseType = Product::PURCHASE_TYPE_NORMAL;
            }

            $spiritualOption = $product->has_spiritual_options ? ($line['spiritual_option'] ?? null) : null;
            $optionPrice = $product->has_spiritual_options
                ? $product->getSpiritualOptionPrice($spiritualOption)
                : 0;
            $baseUnitPrice = $product->getPurchasePrice($purchaseType);
            $unitPrice = $baseUnitPrice + $optionPrice;
            $quantity = max((int) ($line['quantity'] ?? 1), (int) ($product->min_quantity ?? 1));

            $items[] = [
                'line_key' => $lineKey,
                'product' => $product,
                'quantity' => $quantity,
                'purchase_type' => $purchaseType,
                'purchase_type_label' => $purchaseType === Product::PURCHASE_TYPE_SALE ? 'Sale' : 'Normal',
                'spiritual_option' => $spiritualOption,
                'spiritual_option_label' => $product->getSpiritualOptionLabel($spiritualOption),
                'option_price' => $optionPrice,
                'base_unit_price' => $baseUnitPrice,
                'unit_price' => $unitPrice,
                'subtotal' => $unitPrice * $quantity,
            ];
        }

        return $items;
    }

    protected function makeCartLineKey(int $productId, string $purchaseType, ?string $spiritualOption): string
    {
        return implode(':', [
            $productId,
            $purchaseType,
            $spiritualOption ?: 'none',
        ]);
    }
}
