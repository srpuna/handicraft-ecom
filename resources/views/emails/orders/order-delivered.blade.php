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
            background: #16a34a;
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
        <h2>✅ Your Order Has Been Delivered!</h2>
    </div>
    <div class="content">
        <p>Dear {{ $order->client_snapshot['name'] ?? $order->client?->name ?? 'Customer' }},</p>
        <p>Your order <strong>#{{ $order->order_number }}</strong> has been successfully delivered.</p>
        <p>We hope you love your purchase! If you have any questions or concerns, please don't hesitate to contact us.
        </p>
        <p>Thank you for your business!</p>
        <p>Best regards,<br>The Operations Team</p>
    </div>
    <div class="footer">This is an automated message.</div>
</body>

</html>