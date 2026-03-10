<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$clientId = config('services.paypal.client_id', env('PAYPAL_CLIENT_ID'));
$secret = config('services.paypal.secret', env('PAYPAL_CLIENT_SECRET'));

$response = Illuminate\Support\Facades\Http::withBasicAuth($clientId, $secret)
    ->asForm()
    ->post("https://api-m.sandbox.paypal.com/v1/oauth2/token", [
        'grant_type' => 'client_credentials'
    ]);

$token = $response->json('access_token');

$orderId = "6E614197RV5307114";
$orderRes = Illuminate\Support\Facades\Http::withToken($token)
    ->get("https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderId");

echo json_encode($orderRes->json(), JSON_PRETTY_PRINT);
