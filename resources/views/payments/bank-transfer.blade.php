@extends('layouts.app')

@section('title', __('Bank Transfer Payment'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-bank"></i> {{ __('Bank Transfer Payment') }}</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        {{ __('Please transfer the exact amount to the bank account below. After completing the transfer, upload the receipt.') }}
                    </div>

                    <!-- Bank Account Details -->
                    <div class="card bg-light mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-credit-card"></i> {{ __('Bank Account Details') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>{{ __('Bank Name') }}:</strong></div>
                                <div class="col-sm-8">{{ $bankDetails['bank_name'] }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>{{ __('Account Name') }}:</strong></div>
                                <div class="col-sm-8">{{ $bankDetails['account_name'] }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>{{ __('IBAN') }}:</strong></div>
                                <div class="col-sm-8">
                                    <code class="fs-5">{{ $bankDetails['iban'] }}</code>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $bankDetails['iban'] }}')">
                                        <i class="bi bi-clipboard"></i> {{ __('Copy') }}
                                    </button>
                                </div>
                            </div>
                            @if(isset($bankDetails['account_number']))
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>{{ __('Account Number') }}:</strong></div>
                                <div class="col-sm-8">
                                    <code class="fs-5">{{ $bankDetails['account_number'] }}</code>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('{{ $bankDetails['account_number'] }}')">
                                        <i class="bi bi-clipboard"></i> {{ __('Copy') }}
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-receipt"></i> {{ __('Order Details') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>{{ __('Order Number') }}:</strong></div>
                                <div class="col-sm-8"><code>{{ $order->order_number }}</code></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>{{ __('Amount to Transfer') }}:</strong></div>
                                <div class="col-sm-8">
                                    <strong class="text-primary fs-4">{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>{{ __('Payment Status') }}:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-warning">{{ $order->payment_status_label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Receipt Form -->
                    @if($order->payment_status === 'under_review' && !$payment->receipt_path)
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-upload"></i> {{ app()->getLocale() === 'ar' ? 'ارفع إيصال التحويل البنكي' : __('Upload Transfer Receipt') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.bank-transfer.upload', $order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ app()->getLocale() === 'ar' ? 'صورة / ملف PDF للإيصال' : __('Receipt Image/PDF') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="receipt" class="form-control @error('receipt') is-invalid @enderror" 
                                           accept="image/*,.pdf" required>
                                    <small class="form-text text-muted">
                                        {{ app()->getLocale() === 'ar' ? 'الصيغ المقبولة: JPG, PNG, PDF (الحد الأقصى: 2 ميجابايت)' : __('Accepted formats: JPG, PNG, PDF (Max: 2MB)') }}
                                    </small>
                                    @error('receipt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-upload"></i>
                                    {{ app()->getLocale() === 'ar' ? 'ارفع الإيصال' : __('Upload Receipt') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @elseif($payment->receipt_path)
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> 
                        {{ __('Receipt uploaded successfully. Your payment is under review by our team.') }}
                        <br>
                        <small>{{ __('You will be notified once the payment is confirmed.') }}</small>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-eye"></i> {{ __('View Order') }}
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-list"></i> {{ __('My Orders') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('{{ __("Copied to clipboard!") }}');
    }, function(err) {
        console.error('Failed to copy: ', err);
    });
}
</script>
@endpush
@endsection
