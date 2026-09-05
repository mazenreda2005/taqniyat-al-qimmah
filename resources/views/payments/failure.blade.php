@extends('layouts.app')

@section('title', __('Payment Failed'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <!-- Failure Icon -->
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="#dc3545" class="mx-auto">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                    </div>

                    <h1 class="display-4 text-danger mb-3">{{ __('Payment Failed') }}</h1>
                    <p class="lead text-muted mb-4">{{ __('Unfortunately, your payment could not be processed.') }}</p>

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
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
                                <div class="col-sm-8"><strong>{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</strong></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>{{ __('Payment Status') }}:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-danger">{{ $order->payment_status_label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-clockwise"></i> {{ __('Try Again') }}
                        </a>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-eye"></i> {{ __('View Order') }}
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
