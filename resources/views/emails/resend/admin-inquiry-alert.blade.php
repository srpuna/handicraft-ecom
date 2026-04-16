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

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            background: #f9fafb;
        }
    </style>
</head>

<body>
    <h2>New Inquiry Received</h2>
    <div class="card">
        <p><strong>Inquiry #:</strong> {{ $order->order_number }}</p>
        <p><strong>Customer:</strong> {{ $order->client_snapshot['name'] ?? $order->client?->name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $order->client_snapshot['email'] ?? $order->client?->email ?? 'N/A' }}</p>
        <p><strong>Message:</strong> {{ $order->notes ?? '-' }}</p>
    </div>
</body>

</html>
