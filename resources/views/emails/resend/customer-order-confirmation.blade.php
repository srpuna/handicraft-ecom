<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111827;
            max-width: 640px;
            margin: 0 auto;
            padding: 16px;
        }

        .header {
            background: #0f766e;
            color: #ffffff;
            padding: 16px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            border: 1px solid #e5e7eb;
            border-top: 0;
            border-radius: 0 0 8px 8px;
            padding: 16px;
            background: #f8fafc;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Thank you for your purchase</h2>
    </div>

    <div class="content">
        <p>Hi {{ $order->client_snapshot['name'] ?? $order->client?->name ?? 'Customer' }},</p>
        <p>Your payment was successful and your order is now confirmed.</p>

        <p><strong>Order #:</strong> {{ $order->order_number }}</p>
        <p><strong>Total:</strong> ${{ number_format((float) $order->grand_total, 2) }}</p>

        <p>We will send another update once your order is dispatched.</p>
        <p>Regards,<br>{{ config('app.name') }}</p>
    </div>
</body>

</html>
