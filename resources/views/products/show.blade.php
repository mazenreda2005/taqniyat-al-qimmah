@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->images && count($product->images) > 0)
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($product->images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $product->imageUrl($image) }}" class="d-block w-100" alt="{{ $product->name }}" style="max-height: 500px; object-fit: contain;">
                    </div>
                    @endforeach
                </div>
                @if(count($product->images) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                @endif
            </div>
            @else
            <img src="{{ $product->main_image }}" class="img-fluid" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->category->name }}</p>
            <div class="mb-3">
                <span class="badge bg-{{ $product->condition === 'new' ? 'success' : 'warning' }} fs-6">
                    {{ $product->condition === 'new' ? __('New') : __('Used') }}
                </span>
            </div>
            <h2 class="text-primary mb-4">{{ number_format($product->price, 2) }} {{ __('SAR') }}</h2>
            <p class="mb-4">{{ $product->description }}</p>
            
            <div class="mb-3">
                <strong>{{ __('Stock:') }}</strong> 
                @if($product->stock > 0)
                    <span class="text-success">{{ $product->stock }} {{ __('available') }}</span>
                @else
                    <span class="text-danger">{{ __('Out of stock') }}</span>
                @endif
            </div>

            @if($product->is_available && $product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-4">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Quantity') }}</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    {{ __('Add to Cart') }}
                </button>
            </form>
            @else
            <button class="btn btn-secondary btn-lg w-100" disabled>{{ __('Not Available') }}</button>
            @endif
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3>{{ __('Related Products') }}</h3>
        </div>
        @foreach($relatedProducts as $relatedProduct)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ $relatedProduct->main_image }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                    <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($relatedProduct->description, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 text-primary mb-0">{{ number_format($relatedProduct->price, 2) }} {{ __('SAR') }}</span>
                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-sm btn-outline-primary">{{ __('View') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
