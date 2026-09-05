@extends('layouts.app')

@section('title', __('Card Payment'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #1A1F71, #2E3192);">
                    <h4 class="mb-0"><i class="bi bi-credit-card"></i> {{ __('Visa / MasterCard / Mada Payment') }} ({{ __('Test Mode') }})</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> {{ __('This is a test payment gateway. No real charges will be made.') }}
                    </div>

                    <div class="mb-4 text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="#1A1F71">
                                <path d="M21 4H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H3V8h18v10z"/>
                            </svg>
                        </div>
                        <h5>{{ __('Order Details') }}</h5>
                        <p class="mb-1"><strong>{{ __('Order Number') }}:</strong> {{ $order->order_number }}</p>
                        <p class="mb-1"><strong>{{ __('Amount') }}:</strong> {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</p>
                    </div>

                    <hr>

                    <form action="{{ route('payment.visa-mada.callback', $order) }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Card Number') }}</label>
                            <input type="text" class="form-control" value="4111 1111 1111 1111" disabled>
                            <small class="text-muted">{{ __('Test card number') }}</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Expiry Date') }}</label>
                                <input type="text" class="form-control" value="12/25" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('CVV') }}</label>
                                <input type="text" class="form-control" value="123" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Cardholder Name') }}</label>
                            <input type="text" class="form-control" value="Test User" disabled>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg text-white" style="background: linear-gradient(135deg, #1A1F71, #2E3192);" name="status" value="success">
                                <i class="bi bi-check-circle"></i> {{ __('Approve Payment') }}
                            </button>
                            <button type="submit" class="btn btn-danger btn-lg" name="status" value="failed">
                                <i class="bi bi-x-circle"></i> {{ __('Decline Payment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
