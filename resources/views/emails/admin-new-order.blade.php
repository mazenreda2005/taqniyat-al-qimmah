<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('New Order Received') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', 'Arial', sans-serif; background-color: #f4f4f4; padding: 20px; direction: rtl; }
        .email-container { max-width: 700px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .email-header { background: #2c3e50; color: #fff; padding: 20px; text-align: center; }
        .email-header h1 { font-size: 22px; margin-bottom: 5px; }
        .email-body { padding: 20px 24px; }
        .section-title { font-weight: 700; margin-bottom: 10px; margin-top: 15px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { padding: 6px 4px; vertical-align: top; }
        .label { color: #777; font-weight: 600; width: 30%; }
        .value { color: #333; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 8px; font-size: 13px; }
        .items-table th { background: #f8f8f8; }
        .total { text-align: left; font-weight: 700; margin-top: 10px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 12px; color: #fff; }
        .badge-warning { background: #f39c12; }
        .badge-success { background: #27ae60; }
        .badge-danger { background: #e74c3c; }
        .badge-info { background: #3498db; }
        .footer { padding: 12px 20px; background: #f8f8f8; color: #777; font-size: 12px; text-align: center; }
        .btn-link { display: inline-block; margin-top: 10px; padding: 8px 16px; background: #3498db; color: #fff; text-decoration: none; border-radius: 4px; font-size: 13px; }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>{{ $storeName }}</h1>
        <p>{{ __('New Order Received') }}</p>
    </div>
    <div class="email-body">
        <p class="section-title">{{ __('Order Summary') }}</p>
        <table class="info-table">
            <tr>
                <td class="label">{{ __('Order Number') }}:</td>
                <td class="value"><strong>{{ $order->order_number }}</strong></td>
            </tr>
            <tr>
                <td class="label">{{ __('Customer') }}:</td>
                <td class="value">{{ $order->user->name }} ({{ $order->user->email }})</td>
            </tr>
            <tr>
                <td class="label">{{ __('Date') }}:</td>
                <td class="value">{{ $order->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td class="label">{{ __('Payment Method') }}:</td>
                <td class="value">{{ $order->payment_method_label }}</td>
            </tr>
            <tr>
                <td class="label">{{ __('Current Status') }}:</td>
                <td class="value">{{ $order->status_label }}</td>
            </tr>
        </table>

        <p class="section-title">{{ __('Shipping Information') }}</p>
        <table class="info-table">
            <tr>
                <td class="label">{{ __('Name') }}:</td>
                <td class="value">{{ $order->shipping_name }}</td>
            </tr>
            <tr>
                <td class="label">{{ __('Phone') }}:</td>
                <td class="value">{{ $order->shipping_phone }}</td>
            </tr>
            <tr>
                <td class="label">{{ __('Address') }}:</td>
                <td class="value">{{ $order->shipping_address }}</td>
            </tr>
            @if($order->notes)
                <tr>
                    <td class="label">{{ __('Notes') }}:</td>
                    <td class="value">{{ $order->notes }}</td>
                </tr>
            @endif
        </table>

        <p class="section-title">{{ __('Order Items') }}</p>
        <table class="items-table">
            <thead>
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Subtotal') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }} {{ __('SAR') }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }} {{ __('SAR') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p class="total">
            {{ __('Total Amount') }}:
            {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}
        </p>

        <p style="margin-top:15px;">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn-link">
                {{ __('Open order in dashboard') }}
            </a>
        </p>
    </div>
    <div class="footer">
        {{ __('This email was sent automatically when a new order was placed.') }}
    </div>
</div>
</body>
</html>

