<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    private function getAccessToken(): ?string
    {
        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');

        $url = config('services.paypal.mode') === 'live'
            ? 'https://api-m.paypal.com/v1/oauth2/token'
            : 'https://api-m.sandbox.paypal.com/v1/oauth2/token';

        $response = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post($url, ['grant_type' => 'client_credentials']);

        return $response->successful() ? $response->json('access_token') : null;
    }

    /**
     * Create a PayPal order using the authoritative amount from the pending DB order.
     * Expects JSON body: { "order_id": <int> }
     */
    public function createOrder(Request $request)
    {
        $request->validate(['order_id' => ['required', 'integer']]);

        $order = Order::find($request->integer('order_id'));

        if (!$order || $order->is_paid || $order->type !== Order::TYPE_ORDER) {
            return response()->json(['error' => 'Invalid or already paid order.'], 422);
        }

        $token = $this->getAccessToken();
        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $url = config('services.paypal.mode') === 'live'
            ? 'https://api-m.paypal.com/v2/checkout/orders'
            : 'https://api-m.sandbox.paypal.com/v2/checkout/orders';

        // Amount is read from the server – never from the browser
        $amount = number_format((float) $order->grand_total, 2, '.', '');

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => (string) $order->id,
                    'custom_id'    => (string) $order->id,
                    'description'  => 'Order #' . $order->order_number,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value'         => $amount,
                    ],
                ],
            ],
        ];

        $response = Http::withToken($token)->post($url, $payload);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        Log::error('PayPal createOrder failed', ['body' => $response->json()]);
        return response()->json($response->json(), $response->status());
    }

    /**
     * Capture a PayPal payment and mark the local order as paid.
     * Expects JSON body: { "order_id": <int> }
     */
    public function capturePayment(Request $request, string $paypalOrderId)
    {
        $request->validate(['order_id' => ['required', 'integer']]);

        $order = Order::find($request->integer('order_id'));

        if (!$order || $order->type !== Order::TYPE_ORDER) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        if ($order->is_paid) {
            return response()->json(['error' => 'Order is already paid.'], 422);
        }

        $token = $this->getAccessToken();
        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal.'], 500);
        }

        $url = config('services.paypal.mode') === 'live'
            ? "https://api-m.paypal.com/v2/checkout/orders/{$paypalOrderId}/capture"
            : "https://api-m.sandbox.paypal.com/v2/checkout/orders/{$paypalOrderId}/capture";

        $response = Http::withToken($token)
            ->contentType('application/json')
            ->post($url);

        if (!$response->successful()) {
            Log::error('PayPal capturePayment failed', [
                'paypal_order_id' => $paypalOrderId,
                'local_order_id'  => $order->id,
                'body'            => $response->json(),
            ]);
            return response()->json($response->json(), $response->status());
        }

        $capture = $response->json();

        // Verify PayPal reports COMPLETED before marking paid
        $captureStatus = $capture['status'] ?? null;
        if ($captureStatus !== 'COMPLETED') {
            Log::warning('PayPal capture not COMPLETED', ['status' => $captureStatus, 'order_id' => $order->id]);
            return response()->json(['error' => 'Payment was not completed by PayPal.'], 422);
        }

        // Mark order as paid and lock financials (uses a system actor since no logged-in user)
        $order->is_paid = true;
        $order->financial_locked_at = now();
        $order->save();

        // Clear the session cart after a successful purchase
        session()->forget('cart');

        return response()->json([
            'success'      => true,
            'order_number' => $order->order_number,
            'message'      => 'Payment successful. Your order has been placed.',
        ]);
    }
}
