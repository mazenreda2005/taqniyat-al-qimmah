@extends('layouts.app')

@section('title', __('Admin Dashboard'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ __('Admin Dashboard') }}</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Total Orders') }}</h5>
                    <h2>{{ $stats['total_orders'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Pending Orders') }}</h5>
                    <h2>{{ $stats['pending_orders'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Total Products') }}</h5>
                    <h2>{{ $stats['total_products'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Maintenance Requests') }}</h5>
                    <h2>{{ $stats['maintenance_requests'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Quick Actions') }}</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-2 w-100">{{ __('Add New Product') }}</a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-2 w-100">{{ __('Add New Category') }}</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-2 w-100">{{ __('View Orders') }}</a>
                    <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary mb-2 w-100">{{ __('View Maintenance Requests') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Management') }}</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary mb-2 w-100">{{ __('Manage Products') }}</a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary mb-2 w-100">{{ __('Manage Categories') }}</a>
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-outline-info mb-2 w-100">{{ __('Manage Homepage Slider') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
