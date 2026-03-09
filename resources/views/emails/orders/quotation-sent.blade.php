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

        .badge {
            display: inline-block;
            background: #f0fdf4;
            color: #16a34a;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Your Quotation is Ready</h2>
    </div>
    <div class="content">
        <p>Dear {{ $order->client_snapshot['name'] ?? $order->client?->name ?? 'Customer' }},</p>
        <p>We have prepared a quotation for your order. Here are the details:</p>
        <p><strong>Order / Quotation #:</strong> <span class="badge">{{ $order->order_number }}</span></p>
        <p><strong>Grand Total:</strong> ${{ number_format($order->grand_total, 2) }}</p>
        <p>Please review the quotation and get in touch with us to proceed.</p>
        <p>Best regards,<br>The Operations Team</p>
    </div>
    <div class="footer">This is an automated message. Please do not reply directly to this email.</div>
</body>

</html>