<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #2563eb;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }

        .footer {
            background: #f3f4f6;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Your Order is Being Processed</h2>
    </div>
    <div class="content">
        <p>Dear {{ $order->client_snapshot['name'] ?? $order->client?->name ?? 'Customer' }},</p>
        <p>Great news! Your order <strong>#{{ $order->order_number }}</strong> is now being processed by our team.</p>
        <p><strong>Order Total:</strong> ${{ number_format($order->grand_total, 2) }}</p>
        <p>We will notify you once your order is dispatched.</p>
        <p>Best regards,<br>The Operations Team</p>
    </div>
    <div class="footer">This is an automated message.</div>
</body>

</html>
