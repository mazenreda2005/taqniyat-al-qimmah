@extends('layouts.app')

@section('title', __('Checkout'))

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="mb-0">{{ __('Checkout') }}</h1>
            <p class="text-muted">{{ __('Complete your order by providing shipping information and selecting a payment method') }}</p>
        </div>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
        @csrf
        
        <div class="row">
            <!-- Shipping Information -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-truck"></i> {{ __('Shipping Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror" 
                                       value="{{ old('shipping_name', auth()->user()->name) }}" required>
                                @error('shipping_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" 
                                       value="{{ old('shipping_phone', auth()->user()->phone) }}" required>
                                @error('shipping_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Address') }} <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" 
                                      rows="3" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Notes') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-credit-card"></i> {{ __('Payment Method') }} <span class="text-danger">*</span></h5>
                    </div>
                    <div class="card-body">
                        @error('payment_method')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="row g-3">
                            <!-- Visa / MasterCard / Mada -->
                            <div class="col-md-6">
                                <div class="payment-method-card">
                                    <input type="radio" name="payment_method" id="payment_visa_mada" value="visa_mada" 
                                           class="payment-method-radio" required>
                                    <label for="payment_visa_mada" class="payment-method-label">
                                        <div class="payment-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#1A1F71">
                                                <path d="M21 4H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H3V8h18v10z"/>
                                            </svg>
                                        </div>
                                        <div class="payment-info">
                                            <strong>{{ __('Visa / MasterCard / Mada') }}</strong>
                                            <small class="d-block text-muted">{{ __('Secure online payment') }}</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- STC Pay -->
                            <div class="col-md-6">
                                <div class="payment-method-card">
                                    <input type="radio" name="payment_method" id="payment_stc_pay" value="stc_pay" 
                                           class="payment-method-radio" required>
                                    <label for="payment_stc_pay" class="payment-method-label">
                                        <div class="payment-icon stc-pay">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#00D9FF">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </div>
                                        <div class="payment-info">
                                            <strong>{{ __('STC Pay') }}</strong>
                                            <small class="d-block text-muted">{{ __('Pay with STC Pay') }}</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Tamara -->
                            <div class="col-md-6">
                                <div class="payment-method-card">
                                    <input type="radio" name="payment_method" id="payment_tamara" value="tamara" 
                                           class="payment-method-radio" required>
                                    <label for="payment_tamara" class="payment-method-label">
                                        <div class="payment-icon tamara">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#6C5CE7">
                                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                            </svg>
                                        </div>
                                        <div class="payment-info">
                                            <strong>{{ __('Tamara') }}</strong>
                                            <small class="d-block text-muted">{{ __('Buy Now Pay Later') }}</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Bank Transfer -->
                            <div class="col-md-6">
                                <div class="payment-method-card">
                                    <input type="radio" name="payment_method" id="payment_bank_transfer" value="bank_transfer" 
                                           class="payment-method-radio" required>
                                    <label for="payment_bank_transfer" class="payment-method-label">
                                        <div class="payment-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#0066CC">
                                                <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                            </svg>
                                        </div>
                                        <div class="payment-info">
                                            <strong>{{ __('Bank Transfer') }}</strong>
                                            <small class="d-block text-muted">{{ __('Direct bank transfer') }}</small>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Cash on Delivery -->
                            <div class="col-md-6">
                                <div class="payment-method-card">
                                    <input type="radio" name="payment_method" id="payment_cash_on_delivery" value="cash_on_delivery" 
                                           class="payment-method-radio" required>
                                    <label for="payment_cash_on_delivery" class="payment-method-label">
                                        <div class="payment-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#28A745">
                                                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.38-1.8 1.38-1.51 0-2.38-.92-2.5-2.05h-2.21c.12 2.19 1.76 3.42 3.71 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                            </svg>
                                        </div>
                                        <div class="payment-info">
                                            <strong>{{ __('Cash on Delivery') }}</strong>
                                            <small class="d-block text-muted">{{ __('Pay when you receive') }}</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-cart-check"></i> {{ __('Order Summary') }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ __('Quantity') }}: {{ $item->quantity }}</small>
                            </div>
                            <div class="text-end">
                                <strong>{{ number_format($item->subtotal, 2) }} {{ __('SAR') }}</strong>
                            </div>
                        </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 mb-0">{{ __('Total') }}</span>
                            <span class="h4 mb-0 text-primary">
                                <strong>{{ number_format($cartItems->sum(function($item) { return $item->subtotal; }), 2) }} {{ __('SAR') }}</strong>
                            </span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submit-order">
                            <i class="bi bi-lock-fill"></i> {{ __('Complete Order') }}
                        </button>
                        
                        <small class="text-muted d-block text-center mt-2">
                            <i class="bi bi-shield-check"></i> {{ __('Secure payment') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
.payment-method-card {
    position: relative;
}

.payment-method-radio {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.payment-method-label {
    display: flex;
    align-items: center;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fff;
    gap: 15px;
}

.payment-method-label:hover {
    border-color: #007bff;
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.payment-method-radio:checked + .payment-method-label {
    border-color: #28a745;
    background: #f0fff4;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}

.payment-icon {
    flex-shrink: 0;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 8px;
}

.payment-icon.stc-pay {
    background: #e6f7ff;
}

.payment-icon.tamara {
    background: #f3f0ff;
}

.payment-info {
    flex-grow: 1;
}

.payment-info strong {
    display: block;
    margin-bottom: 4px;
    color: #333;
}

.payment-info small {
    color: #666;
    font-size: 0.85em;
}

.sticky-top {
    position: sticky;
    z-index: 1020;
}

@media (max-width: 991px) {
    .sticky-top {
        position: relative;
        top: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-order');
    
    form.addEventListener('submit', function(e) {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        
        if (!selectedPayment) {
            e.preventDefault();
            alert('{{ __("Please select a payment method") }}');
            return false;
        }
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __("Processing...") }}';
    });
});
</script>
@endpush
@endsection
