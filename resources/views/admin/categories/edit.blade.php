@extends('layouts.app')

@section('title', __('Edit Category'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Name (Arabic)') }} *</label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar', $category->name_ar) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('Name (English)') }} *</label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $category->name_en) }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description (Arabic)') }}</label>
                            <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar', $category->description_ar) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description (English)') }}</label>
                            <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $category->description_en) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Image') }}</label>
                            @if($category->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="max-height: 100px;">
                            </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="form-text text-muted">{{ __('Leave empty to keep existing image.') }}</small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $category->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update Category') }}</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
