@extends('layouts.app')

@section('title', __('Maintenance Request Details'))

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1>{{ __('Maintenance Request Details') }}</h1>
            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Request Information') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Request Number:') }}</strong> {{ $maintenanceRequest->request_number }}</p>
                    <p><strong>{{ __('Customer:') }}</strong> {{ $maintenanceRequest->user->name }}</p>
                    <p><strong>{{ __('Email:') }}</strong> {{ $maintenanceRequest->user->email }}</p>
                    <p><strong>{{ __('Phone:') }}</strong> {{ $maintenanceRequest->user->phone ?? '-' }}</p>
                    <p><strong>{{ __('Device Name:') }}</strong> {{ $maintenanceRequest->device_name }}</p>
                    <p><strong>{{ __('Issue Description:') }}</strong></p>
                    <p>{{ $maintenanceRequest->issue_description }}</p>
                    <p><strong>{{ __('Date:') }}</strong> {{ $maintenanceRequest->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Update Request') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.maintenance.update', $maintenanceRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $maintenanceRequest->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="in_progress" {{ $maintenanceRequest->status == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                                <option value="completed" {{ $maintenanceRequest->status == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                <option value="cancelled" {{ $maintenanceRequest->status == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Cost') }} ({{ __('SAR') }})</label>
                            <input type="number" name="cost" class="form-control" step="0.01" value="{{ old('cost', $maintenanceRequest->cost) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Admin Notes') }}</label>
                            <textarea name="admin_notes" class="form-control" rows="4">{{ old('admin_notes', $maintenanceRequest->admin_notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Update Request') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
