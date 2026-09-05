@extends('layouts.app')

@section('title', __('Order Details'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ __('Order Details') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Order Information') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Order Number:') }}</strong> {{ $order->order_number }}</p>
                    <p><strong>{{ __('Date:') }}</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>{{ __('Status:') }}</strong> 
                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                            {{ $order->status_label }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Order Items') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
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
                                <td>{{ number_format($item->subtotal, 2) }} {{ __('SAR') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">{{ __('Total') }}</th>
                                <th>{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Shipping Information') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Name:') }}</strong> {{ $order->shipping_name }}</p>
                    <p><strong>{{ __('Phone:') }}</strong> {{ $order->shipping_phone }}</p>
                    <p><strong>{{ __('Address:') }}</strong> {{ $order->shipping_address }}</p>
                    @if($order->notes)
                    <p><strong>{{ __('Notes:') }}</strong> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
