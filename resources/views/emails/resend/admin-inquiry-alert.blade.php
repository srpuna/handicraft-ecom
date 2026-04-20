<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Inquiry</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.container {
max-width: 650px;
margin: auto;
background: #ffffff;
border-radius: 8px;
overflow: hidden;
}

.header {
background-color: #2D4B3A;
color: white;
padding: 15px;
text-align: center;
}

.content {
padding: 20px;
color: #333;
}

.customer-box {
background: #f9f9f9;
padding: 15px;
border-radius: 5px;
margin-bottom: 20px;
}

table {
width: 100%;
border-collapse: collapse;
margin-top: 15px;
}

table th, table td {
border: 1px solid #ddd;
padding: 10px;
font-size: 14px;
text-align: left;
}

table th {
background-color: #2D4B3A;
color: white;
}

.product-img {
width: 50px;
border-radius: 5px;
}

.total-row td {
font-weight: bold;
background: #f1f1f1;
}

.grand-total td {
font-weight: bold;
background: #2D4B3A;
color: white;
}

.button {
display: inline-block;
padding: 12px 20px;
margin-top: 20px;
background-color: #2D4B3A;
color: white;
text-decoration: none;
border-radius: 5px;
}

.footer {
text-align: center;
font-size: 12px;
color: #777;
padding: 15px;
} </style>

</head>

<body>

<div class="container">
        <div class="header">
            <h2>New Order Inquiry</h2>
        </div>

        <div class="content">
            <div class="customer-box">
                <p><strong>Customer Name:</strong> {{ $order->client_snapshot['name'] ?? $order->client?->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->client_snapshot['email'] ?? $order->client?->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $order->client_snapshot['phone'] ?? $order->client?->phone ?? 'N/A' }}</p>

                @if(!empty($order->client_snapshot['shipping_address']) || !empty($order->client?->shipping_address))
                    <p><strong>Shipping Address:</strong><br>
                        {!! nl2br(e($order->client_snapshot['shipping_address'] ?? $order->client?->shipping_address)) !!}
                    </p>
                @endif
            </div>

            <p><strong>Inquiry #:</strong> {{ $order->order_number }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $order->notes ?? 'No message provided.' }}</p>

            @if($order->relationLoaded('items') ? $order->items->isNotEmpty() : $order->items()->exists())
                <p>The inquiry includes the following items:</p>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if(!empty($item->product_snapshot['image_url']))
                                        <img src="{{ $item->product_snapshot['image_url'] }}" alt="Product image" class="product-img">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->product_snapshot['name'] ?? $item->product?->name ?? 'Unknown product' }}</td>
                                <td>{{ $item->product_snapshot['sku'] ?? $item->product?->sku ?? '-' }}</td>
                                <td>${{ number_format($item->unit_price ?? 0, 2) }}</td>
                                <td>{{ $item->quantity ?? 0 }}</td>
                                <td>${{ number_format($item->line_total ?? (($item->unit_price ?? 0) * ($item->quantity ?? 0)), 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="5" style="text-align: right;">Subtotal</td>
                            <td>${{ number_format($order->subtotal ?? 0, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="5" style="text-align: right;">Shipping</td>
                            <td>${{ number_format($order->shipping_cost ?? 0, 2) }}</td>
                        </tr>
                        <tr class="grand-total">
                            <td colspan="5" style="text-align: right;">Grand Total</td>
                            <td>${{ number_format($order->grand_total ?? 0, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p>No items were attached to this inquiry.</p>
            @endif

            <p>Please review the inquiry and follow up with the customer.</p>
        </div>

        <div class="footer">
            Handicraft Nepal NP
        </div>
    </div>

</body>
</html>
