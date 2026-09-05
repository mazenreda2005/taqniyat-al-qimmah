@extends('layouts.app')

@section('title', __('STC Pay Payment'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #00D9FF, #0099CC);">
                    <h4 class="mb-0"><i class="bi bi-phone"></i> STC Pay ({{ __('Test Mode') }})</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> {{ __('This is a test payment gateway. No real charges will be made.') }}
                    </div>

                    <div class="mb-4 text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="#00D9FF">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <h5>{{ __('Order Details') }}</h5>
                        <p class="mb-1"><strong>{{ __('Order Number') }}:</strong> {{ $order->order_number }}</p>
                        <p class="mb-1"><strong>{{ __('Amount') }}:</strong> {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</p>
                    </div>

                    <hr>

                    <form action="{{ route('payment.stc-pay.callback', $order) }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Mobile Number') }}</label>
                            <input type="text" class="form-control" value="05XX XXX XXX" disabled>
                            <small class="text-muted">{{ __('STC Pay mobile number') }}</small>
                        </div>

                        <div class="mb-3">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> 
                                {{ __('In production, you will be redirected to STC Pay app or website to complete the payment.') }}
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg text-white" style="background: linear-gradient(135deg, #00D9FF, #0099CC);" name="status" value="SUCCESS">
                                <i class="bi bi-check-circle"></i> {{ __('Approve Payment') }}
                            </button>
                            <button type="submit" class="btn btn-danger btn-lg" name="status" value="FAILED">
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
