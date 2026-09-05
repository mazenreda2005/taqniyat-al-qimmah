@extends('layouts.app')

@section('title', __('Tamara Payment'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #6C5CE7, #A29BFE);">
                    <h4 class="mb-0"><i class="bi bi-calendar-check"></i> Tamara - {{ __('Buy Now Pay Later') }} ({{ __('Test Mode') }})</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> {{ __('This is a test payment gateway. No real charges will be made.') }}
                    </div>

                    <div class="mb-4 text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="#6C5CE7">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h5>{{ __('Order Details') }}</h5>
                        <p class="mb-1"><strong>{{ __('Order Number') }}:</strong> {{ $order->order_number }}</p>
                        <p class="mb-1"><strong>{{ __('Amount') }}:</strong> {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</p>
                        <p class="text-muted"><small>{{ __('Pay in 3 installments') }}</small></p>
                    </div>

                    <hr>

                    <form action="{{ route('payment.tamara.callback', $order) }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Payment Plan') }}</label>
                            <select class="form-select" disabled>
                                <option>3 installments ({{ number_format($order->total_amount / 3, 2) }} {{ __('SAR') }} each)</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg text-white" style="background: linear-gradient(135deg, #6C5CE7, #A29BFE);" name="status" value="approved">
                                <i class="bi bi-check-circle"></i> {{ __('Approve Payment') }}
                            </button>
                            <button type="submit" class="btn btn-danger btn-lg" name="status" value="declined">
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
