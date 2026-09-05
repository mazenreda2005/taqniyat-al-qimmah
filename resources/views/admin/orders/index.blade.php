@extends('layouts.app')

@section('title', __('Manage Orders'))

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>{{ __('Orders Management') }}</h1>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> {{ __('Filters') }}</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">{{ __('Payment Method') }}</label>
                            <select name="payment_method" class="form-select">
                                <option value="">{{ __('All Methods') }}</option>
                                <option value="visa_mada" {{ request('payment_method') === 'visa_mada' ? 'selected' : '' }}>
                                    {{ __('Visa / MasterCard / Mada') }}
                                </option>
                                <option value="stc_pay" {{ request('payment_method') === 'stc_pay' ? 'selected' : '' }}>
                                    {{ __('STC Pay') }}
                                </option>
                                <option value="tamara" {{ request('payment_method') === 'tamara' ? 'selected' : '' }}>
                                    {{ __('Tamara') }}
                                </option>
                                <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>
                                    {{ __('Bank Transfer') }}
                                </option>
                                <option value="cash_on_delivery" {{ request('payment_method') === 'cash_on_delivery' ? 'selected' : '' }}>
                                    {{ __('Cash on Delivery') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('Payment Status') }}</label>
                            <select name="payment_status" class="form-select">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>
                                    {{ __('Paid') }}
                                </option>
                                <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>
                                    {{ __('Failed') }}
                                </option>
                                <option value="under_review" {{ request('payment_status') === 'under_review' ? 'selected' : '' }}>
                                    {{ __('Under Review') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('Order Status') }}</label>
                            <select name="status" class="form-select">
                                <option value="">{{ __('All Statuses') }}</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>
                                    {{ __('Processing') }}
                                </option>
                                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>
                                    {{ __('Shipped') }}
                                </option>
                                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>
                                    {{ __('Delivered') }}
                                </option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                    {{ __('Cancelled') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> {{ __('Filter') }}
                                </button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> {{ __('Reset') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Orders List') }}</h5>
                    <span class="badge bg-info">{{ $orders->total() }} {{ __('Orders') }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Order Number') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Payment Method') }}</th>
                                    <th>{{ __('Payment Status') }}</th>
                                    <th>{{ __('Order Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td><code>{{ $order->order_number }}</code></td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td><strong>{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->payment_method_label }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $paymentStatusClass = match($order->payment_status) {
                                                'paid' => 'success',
                                                'failed' => 'danger',
                                                'under_review' => 'warning',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $paymentStatusClass }}">
                                            {{ $order->payment_status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'delivered' => 'success',
                                                'cancelled' => 'danger',
                                                'processing' => 'info',
                                                'shipped' => 'primary',
                                                default => 'warning',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> {{ __('View') }}
                                        </a>
                                        @if($order->status === 'pending')
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('{{ __('Are you sure you want to approve this order?') }}')">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('{{ __('Are you sure you want to reject this order?') }}')">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="text-muted mt-3">{{ __('No orders found.') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

