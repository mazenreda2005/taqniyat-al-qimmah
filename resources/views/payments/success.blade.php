@extends('layouts.app')

@section('title', __('Payment Success'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="#28a745" class="mx-auto">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>

                    @if($order->payment_method === 'cash_on_delivery')
                    {{-- رسالة خاصة بالدفع عند الاستلام --}}
                    <div class="alert alert-success border-0 mb-4 py-4" role="alert">
                        <h2 class="h4 mb-2">✓ {{ __('Order confirmed!') }}</h2>
                        <p class="mb-2">{{ __('Your order has been received. We will contact you to arrange delivery.') }}</p>
                        <p class="h5 text-success mb-0 fw-bold">✓ {{ __('The operation has been completed successfully.') }}</p>
                    </div>
                    <h1 class="display-5 text-success mb-2">{{ __('The operation has been completed successfully.') }}</h1>
                    <p class="lead text-muted mb-4">{{ __('Payment will be collected when you receive your order.') }}</p>
                    @else
                    <h1 class="display-4 text-success mb-3">{{ __('Payment Successful!') }}</h1>
                    <p class="lead text-muted mb-4">{{ __('Your payment has been processed successfully.') }}</p>
                    @endif

                    <!-- Order Details -->
                    <div class="card bg-light mb-4">
                        <div class="card-body text-start">
                            <h5 class="card-title mb-3">{{ __('Order Details') }}</h5>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>{{ __('Order Number') }}:</strong></div>
                                <div class="col-sm-8">{{ $order->order_number }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>{{ __('Payment Method') }}:</strong></div>
                                <div class="col-sm-8">{{ $order->payment_method_label }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>{{ __('Total Amount') }}:</strong></div>
                                <div class="col-sm-8"><strong class="text-success">{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>{{ __('Payment Status') }}:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-success">{{ $order->payment_status_label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-eye"></i> {{ __('View Order Details') }}
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-list"></i> {{ __('My Orders') }}
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-house"></i> {{ __('Back to Home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
