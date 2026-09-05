@extends('layouts.app')

@section('title', __('Manage Slider'))

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>{{ __('Homepage Slider Management') }}</h1>
            <p class="text-muted">{{ __('Select and order products to display in the homepage slider.') }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Slider Settings -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Slider Settings') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.slider.settings') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Slide Duration (milliseconds)') }}</label>
                            <input type="number" name="slide_duration" class="form-control" 
                                   value="{{ $settings->slide_duration }}" min="1000" max="60000" step="1000">
                            <small class="form-text text-muted">{{ __('Default: 10000ms (10 seconds)') }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Maximum Products') }}</label>
                            <input type="number" name="max_products" class="form-control" 
                                   value="{{ $settings->max_products }}" min="1" max="20">
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                   {{ $settings->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">{{ __('Enable Slider') }}</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">{{ __('Save Settings') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Featured Products Selection -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Featured Products in Slider') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.slider.products') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Select Products (drag to reorder)') }}</label>
                            <div id="featured-products" class="list-group mb-3">
                                @foreach($featuredProducts as $product)
                                <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $product->id }}">
                                    <div class="d-flex align-items-center">
                                        <span class="drag-handle me-3" style="cursor: grab;">☰</span>
                                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover;" class="me-3">
                                        <span>{{ $product->name }}</span>
                                    </div>
                                    <input type="hidden" name="products[]" value="{{ $product->id }}">
                                    <button type="button" class="btn btn-sm btn-danger remove-product">×</button>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Add Product') }}</label>
                            <select id="add-product-select" class="form-select">
                                <option value="">{{ __('Select a product to add...') }}</option>
                                @foreach($products as $product)
                                    @if(!$product->is_featured)
                                    <option value="{{ $product->id }}" 
                                            data-name="{{ $product->name }}"
                                            data-image="{{ $product->main_image }}">
                                        {{ $product->name }} - {{ number_format($product->price, 2) }} {{ __('SAR') }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">{{ __('Save Featured Products') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const featuredList = document.getElementById('featured-products');
    const addSelect = document.getElementById('add-product-select');
    
    // Add product to featured list
    addSelect.addEventListener('change', function() {
        if (!this.value) return;
        
        const option = this.options[this.selectedIndex];
        const productId = this.value;
        const productName = option.dataset.name;
        const productImage = option.dataset.image;
        
        // Create new list item
        const item = document.createElement('div');
        item.className = 'list-group-item d-flex justify-content-between align-items-center';
        item.dataset.id = productId;
        item.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="drag-handle me-3" style="cursor: grab;">☰</span>
                <img src="${productImage}" alt="${productName}" 
                     style="width: 50px; height: 50px; object-fit: cover;" class="me-3">
                <span>${productName}</span>
            </div>
            <input type="hidden" name="products[]" value="${productId}">
            <button type="button" class="btn btn-sm btn-danger remove-product">×</button>
        `;
        
        featuredList.appendChild(item);
        
        // Remove from select options
        option.remove();
        this.value = '';
    });
    
    // Remove product from featured list
    featuredList.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            const item = e.target.closest('.list-group-item');
            const productId = item.dataset.id;
            const productName = item.querySelector('span:not(.drag-handle)').textContent;
            
            // Add back to select
            const option = document.createElement('option');
            option.value = productId;
            option.textContent = productName;
            addSelect.appendChild(option);
            
            // Remove from list
            item.remove();
        }
    });
    
    // Simple drag and drop reordering
    let draggedItem = null;
    
    featuredList.addEventListener('dragstart', function(e) {
        if (e.target.classList.contains('list-group-item')) {
            draggedItem = e.target;
            e.target.style.opacity = '0.5';
        }
    });
    
    featuredList.addEventListener('dragend', function(e) {
        if (e.target.classList.contains('list-group-item')) {
            e.target.style.opacity = '1';
        }
    });
    
    featuredList.addEventListener('dragover', function(e) {
        e.preventDefault();
    });
    
    featuredList.addEventListener('drop', function(e) {
        e.preventDefault();
        const target = e.target.closest('.list-group-item');
        if (target && draggedItem !== target) {
            const items = Array.from(featuredList.children);
            const draggedIndex = items.indexOf(draggedItem);
            const targetIndex = items.indexOf(target);
            
            if (draggedIndex < targetIndex) {
                target.after(draggedItem);
            } else {
                target.before(draggedItem);
            }
        }
    });
    
    // Make items draggable
    featuredList.querySelectorAll('.list-group-item').forEach(item => {
        item.draggable = true;
    });
});
</script>
@endpush
@endsection
