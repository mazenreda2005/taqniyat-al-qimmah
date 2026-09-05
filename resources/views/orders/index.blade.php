@extends('layouts.app')

@section('title', __('My Orders'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ __('My Orders') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Order Number') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
            @else
            <div class="alert alert-info">
                <p>{{ __('You have no orders yet.') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">{{ __('Browse Products') }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
