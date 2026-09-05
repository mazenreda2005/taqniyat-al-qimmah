@extends('layouts.app')

@section('title', __('Order Details'))

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1>{{ __('Order Details') }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
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
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Order Information') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Order Number:') }}</strong> {{ $order->order_number }}</p>
                    <p><strong>{{ __('Date:') }}</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>{{ __('Customer:') }}</strong> {{ $order->user->name }}</p>
                    <p><strong>{{ __('Email:') }}</strong> {{ $order->user->email }}</p>
                </div>
            </div>

            <div class="card mb-4">
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

            <!-- Payment Information -->
            @if($order->payment)
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Payment Information') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Payment Method:') }}</strong> {{ $order->payment_method_label }}</p>
                    <p><strong>{{ __('Payment Status:') }}</strong> 
                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                            {{ $order->payment_status_label }}
                        </span>
                    </p>
                    @if($order->payment->transaction_id)
                    <p><strong>{{ __('Transaction ID:') }}</strong> <code>{{ $order->payment->transaction_id }}</code></p>
                    @endif
                    @if($order->payment->receipt_path)
                    <p><strong>{{ __('Receipt:') }}</strong> 
                        <a href="{{ asset('storage/' . $order->payment->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download"></i> {{ __('View Receipt') }}
                        </a>
                    </p>
                    @endif
                    
                    <!-- Bank Transfer Actions -->
                    @if($order->payment_method === 'bank_transfer' && $order->payment_status === 'under_review')
                    <hr>
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.payments.approve', $order->payment) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('{{ __('Are you sure you want to approve this payment?') }}')">
                                <i class="bi bi-check-circle"></i> {{ __('Approve Payment') }}
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle"></i> {{ __('Reject Payment') }}
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Update Status') }}</h5>
                </div>
                <div class="card-body">
                    @if($order->status === 'pending')
                        <div class="mb-3">
                            <div class="d-grid gap-2">
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('{{ __('Are you sure you want to approve this order?') }}')">
                                        <i class="bi bi-check-circle"></i> {{ __('Approve Order') }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('{{ __('Are you sure you want to reject this order?') }}')">
                                        <i class="bi bi-x-circle"></i> {{ __('Reject Order') }}
                                    </button>
                                </form>
                            </div>
                            <hr>
                        </div>
                    @endif
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Update Status') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
@if($order->payment && $order->payment_method === 'bank_transfer' && $order->payment_status === 'under_review')
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.payments.reject', $order->payment) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Reject Payment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> 
                        {{ __('Are you sure you want to reject this payment?') }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Rejection Reason') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                        <textarea name="rejection_reason" class="form-control" rows="3" 
                                  placeholder="{{ __('Please provide a reason for rejection...') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Reject Payment') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
        </div>
    </div>
</div>
@endsection
