@extends('layouts.app')

@section('title', __('Shopping Cart'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ __('Shopping Cart') }}</h1>
        </div>
    </div>

    @if($cartItems->count() > 0)
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Subtotal') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" style="width: 80px; height: 80px; object-fit: cover;" class="me-3">
                                        <div>
                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->product->category->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->product->price, 2) }} {{ __('SAR') }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm" style="width: 80px;" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>{{ number_format($item->subtotal, 2) }} {{ __('SAR') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Remove') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Order Summary') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>{{ __('Subtotal') }}</span>
                        <span>{{ number_format($total, 2) }} {{ __('SAR') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>{{ __('Total') }}</strong>
                        <strong>{{ number_format($total, 2) }} {{ __('SAR') }}</strong>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100 btn-lg">{{ __('Proceed to Checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h4>{{ __('Your cart is empty') }}</h4>
                <p>{{ __('Add some products to your cart to continue shopping.') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">{{ __('Browse Products') }}</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
