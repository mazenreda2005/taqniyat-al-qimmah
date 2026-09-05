<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Order Confirmation') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Cairo', 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            direction: rtl;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .email-header p {
            font-size: 16px;
            opacity: 0.9;
        }
        .email-body {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .confirmation-message {
            background-color: #e8f5e9;
            border-right: 4px solid #4caf50;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
        }
        .confirmation-message h2 {
            color: #2e7d32;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .order-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
        }
        .info-value {
            color: #333;
            font-weight: 500;
        }
        .order-number {
            font-size: 24px;
            color: #667eea;
            font-weight: 700;
        }
        .products-section {
            margin-top: 25px;
        }
        .products-section h3 {
            color: #333;
            font-size: 20px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .product-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
            border-radius: 5px;
            border-right: 3px solid #667eea;
        }
        .product-name {
            font-weight: 600;
            color: #333;
            flex: 1;
        }
        .product-details {
            text-align: left;
            color: #666;
            font-size: 14px;
        }
        .total-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 25px;
            text-align: center;
        }
        .total-label {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .total-amount {
            font-size: 32px;
            font-weight: 700;
        }
        .email-footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .email-footer a {
            color: #667eea;
            text-decoration: none;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: 600;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            .product-item {
                flex-direction: column;
            }
            .product-details {
                text-align: right;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ $storeName }}</h1>
            <p>{{ __('Order Confirmation') }}</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                {{ __('Hello') }} {{ $order->user->name }},
            </div>

            <div class="confirmation-message">
                <h2>✓ {{ __('Thank you for your order!') }}</h2>
                <p>{{ __('Your order has been received and is being processed.') }}</p>
            </div>

            <!-- Order Information -->
            <div class="order-info">
                <div class="info-row">
                    <span class="info-label">{{ __('Order Number') }}:</span>
                    <span class="info-value order-number">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Order Date') }}:</span>
                    <span class="info-value">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Payment Method') }}:</span>
                    <span class="info-value">{{ $order->payment_method_label }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Order Status') }}:</span>
                    <span class="info-value">{{ $order->status_label }}</span>
                </div>
            </div>

            <!-- Products List -->
            <div class="products-section">
                <h3>{{ __('Order Items') }}</h3>
                @foreach($order->items as $item)
                <div class="product-item">
                    <div class="product-name">
                        {{ $item->product->name }}
                    </div>
                    <div class="product-details">
                        {{ __('Quantity') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }} {{ __('SAR') }}<br>
                        {{ __('Subtotal') }}: <strong>{{ number_format($item->subtotal, 2) }} {{ __('SAR') }}</strong>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="total-section">
                <div class="total-label">{{ __('Total Amount') }}</div>
                <div class="total-amount">{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</div>
            </div>

            <!-- Shipping Information -->
            @if($order->shipping_name)
            <div class="order-info" style="margin-top: 25px;">
                <h3 style="margin-bottom: 15px; color: #333;">{{ __('Shipping Information') }}</h3>
                <div class="info-row">
                    <span class="info-label">{{ __('Name') }}:</span>
                    <span class="info-value">{{ $order->shipping_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Phone') }}:</span>
                    <span class="info-value">{{ $order->shipping_phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Address') }}:</span>
                    <span class="info-value">{{ $order->shipping_address }}</span>
                </div>
            </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('orders.show', $order) }}" class="button">
                    {{ __('View Order Details') }}
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ $storeName }}. {{ __('All rights reserved.') }}</p>
            <p style="margin-top: 10px;">
                {{ __('If you have any questions, please contact us.') }}
            </p>
        </div>
    </div>
</body>
</html>
