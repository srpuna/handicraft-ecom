<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayPalController extends Controller
{
    private function getAccessToken()
    {
        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');

        $url = config('services.paypal.mode') === 'live' 
            ? "https://api-m.paypal.com/v1/oauth2/token" 
            : "https://api-m.sandbox.paypal.com/v1/oauth2/token";

        $response = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post($url, [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            return $response->json('access_token');
        }

        return null;
    }

    public function createOrder(Request $request)
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal'], 500);
        }

        $url = config('services.paypal.mode') === 'live' 
            ? "https://api-m.paypal.com/v2/checkout/orders" 
            : "https://api-m.sandbox.paypal.com/v2/checkout/orders";

        // IMPORTANT: In production, always fetch the cart total from the database securely.
        // For testing via Postman, we allow passing 'amount', default is 100.00
        $amount = $request->input('amount', '100.00');

        $payload = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => uniqid(),
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]
        ];

        $response = Http::withToken($token)
            ->post($url, $payload);

        if ($response->successful()) {
            // Return the full object which includes the order 'id'
            return response()->json($response->json());
        }

        return response()->json($response->json(), $response->status());
    }

    public function capturePayment(Request $request, $orderId)
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Failed to get access token from PayPal'], 500);
        }

        $url = config('services.paypal.mode') === 'live' 
            ? "https://api-m.paypal.com/v2/checkout/orders/$orderId/capture" 
            : "https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderId/capture";

        $response = Http::withToken($token)
            ->contentType('application/json')
            ->post($url);

        if ($response->successful()) {
            // The payment is successful. Here you would normally:
            // 1. Find the order in your DB.
            // 2. Mark it as paid.
            // 3. Clear the user's cart.
            return response()->json($response->json());
        }

        return response()->json($response->json(), $response->status());
    }
}
