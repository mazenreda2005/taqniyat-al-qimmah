@extends('layouts.app')

@section('title', __('Products'))

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold h2 text-dark">{{ __('Products') }}</h1>
            <p class="text-muted">{{ __('Explore our hardware, smart devices, cybersecurity gear & tech solutions') }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Filters -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white p-3 border-0">
                    <h5 class="mb-0 fw-bold fs-6 d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/></svg>
                        {{ __('Filters') }}
                    </h5>
                </div>
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('products.index') }}">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">{{ __('Category') }}</label>
                            <select name="category" class="form-select rounded-3">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">{{ __('Condition') }}</label>
                            <select name="condition" class="form-select rounded-3">
                                <option value="">{{ __('All') }}</option>
                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>{{ __('New') }}</option>
                                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>{{ __('Used') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">{{ __('Search') }}</label>
                            <input type="text" name="search" class="form-control rounded-3" value="{{ request('search') }}" placeholder="{{ __('Search products...') }}">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold py-2 mb-2">{{ __('Apply Filters') }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-light border rounded-pill w-100 fw-semibold text-secondary py-2">{{ __('Reset') }}</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="row">
                @forelse($products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 h-100 shadow-sm rounded-4 overflow-hidden card-hover-effect">
                        <img src="{{ $product->main_image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 210px; object-fit: cover;" loading="lazy">
                        <div class="card-body d-flex flex-column p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-{{ $product->condition === 'new' ? 'success' : 'warning' }} px-2 py-1">
                                    {{ $product->condition === 'new' ? __('New') : __('Used') }}
                                </span>
                                @if($product->category)
                                <span class="badge bg-light text-dark border small">{{ $product->category->name }}</span>
                                @endif
                            </div>
                            <h5 class="card-title fw-bold fs-6 mb-2 text-dark">{{ $product->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1 mb-3">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="h5 fw-bold text-primary mb-0">{{ number_format($product->price, 2) }} {{ __('SAR') }}</span>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary rounded-pill w-100 fw-bold py-2">{{ __('View Details') }}</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info rounded-4 p-4 text-center border-0 shadow-sm">
                        <h5 class="fw-bold mb-1">{{ __('No products found.') }}</h5>
                        <p class="mb-0 text-muted">{{ __('Try adjusting your filter or search terms.') }}</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
