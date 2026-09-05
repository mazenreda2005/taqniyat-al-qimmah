@extends('layouts.app')

@section('title', __('Add New Product'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ __('Add New Product') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Category') }} *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Name (Arabic)') }} *</label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Name (English)') }} *</label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description (Arabic)') }} *</label>
                            <textarea name="description_ar" class="form-control" rows="3" required>{{ old('description_ar') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description (English)') }} *</label>
                            <textarea name="description_en" class="form-control" rows="3" required>{{ old('description_en') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Price') }} *</label>
                                <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Stock') }} *</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Condition') }} *</label>
                            <select name="condition" class="form-select" required>
                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>{{ __('New') }}</option>
                                <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>{{ __('Used') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Images') }}</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="form-text text-muted">{{ __('You can select multiple images.') }}</small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_available" class="form-check-input" id="is_available" {{ old('is_available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">{{ __('Available') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create Product') }}</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
