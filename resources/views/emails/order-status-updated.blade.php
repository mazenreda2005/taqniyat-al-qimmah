<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Order Status Updated') }}</title>
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
            font-size: 24px;
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
        .status-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        .status-approved {
            background-color: #e8f5e9;
            border-right: 4px solid #4caf50;
            color: #2e7d32;
        }
        .status-cancelled {
            background-color: #ffebee;
            border-right: 4px solid #f44336;
            color: #c62828;
        }
        .order-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
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
        .email-footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 10px 24px;
            background-color: #667eea;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $storeName }}</h1>
            <p>{{ __('Order Status Updated') }}</p>
        </div>

        <div class="email-body">
            <div class="greeting">
                {{ __('Hello') }} {{ $order->user->name }},
            </div>

            @php
                $isApproved = $order->status === 'processing' || $order->status === 'shipped' || $order->status === 'delivered';
            @endphp

            <div class="status-box {{ $order->status === 'cancelled' ? 'status-cancelled' : 'status-approved' }}">
                @if($order->status === 'cancelled')
                    <h2>✕ {{ __('Your order has been cancelled') }}</h2>
                    <p>{{ __('We are sorry to inform you that your order has been cancelled by the store.') }}</p>
                @else
                    <h2>✓ {{ __('Your order has been approved') }}</h2>
                    <p>{{ __('Your order status has been updated and it is now being processed.') }}</p>
                @endif
            </div>

            <div class="order-info">
                <div class="info-row">
                    <span class="info-label">{{ __('Order Number') }}:</span>
                    <span class="info-value">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Order Date') }}:</span>
                    <span class="info-value">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Current Status') }}:</span>
                    <span class="info-value">{{ $order->status_label }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">{{ __('Total Amount') }}:</span>
                    <span class="info-value">{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</span>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('orders.show', $order) }}" class="button">
                    {{ __('View Order Details') }}
                </a>
            </div>
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ $storeName }}. {{ __('All rights reserved.') }}</p>
        </div>
    </div>
</body>
</html>

