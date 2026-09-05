@extends('layouts.app')

@section('title', __('My Profile'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ __('My Profile') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Profile Information') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Address') }}</label>
                            <textarea name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Change Password') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">{{ __('Current Password') }}</label>
                            <div class="input-group">
                                <input id="profile_current_password" type="password" name="current_password" class="form-control" required>
                                <button class="btn btn-outline-secondary js-toggle-password" type="button" data-target="#profile_current_password" aria-label="Show password">
                                    <span class="js-eye">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                                            <path d="M8 5.5A2.5 2.5 0 1 0 8 10a2.5 2.5 0 0 0 0-4.5z"/>
                                        </svg>
                                    </span>
                                    <span class="js-eye-slash d-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M13.359 11.238C14.443 10.131 15.2 8.86 15.2 8.86s-3-5.5-8-5.5c-1.067 0-2.053.252-2.951.642l1.156 1.156A6.34 6.34 0 0 1 7.2 4.36c4.065 0 6.51 3.834 6.51 3.834a13.13 13.13 0 0 1-1.851 2.287l1.5 1.5z"/>
                                            <path d="M3.36 4.762C2.156 5.874 1.2 7.14 1.2 7.14s3 5.5 8 5.5c1.41 0 2.662-.32 3.74-.813l-1.2-1.2a6.75 6.75 0 0 1-2.54.513c-4.065 0-6.51-3.834-6.51-3.834.603-.85 1.33-1.62 2.16-2.27l-1.49-1.49z"/>
                                            <path d="M1.146 1.146a.5.5 0 0 1 .708 0l13 13a.5.5 0 0 1-.708.708l-13-13a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('New Password') }}</label>
                            <div class="input-group">
                                <input id="profile_new_password" type="password" name="password" class="form-control" required>
                                <button class="btn btn-outline-secondary js-toggle-password" type="button" data-target="#profile_new_password" aria-label="Show password">
                                    <span class="js-eye">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                                            <path d="M8 5.5A2.5 2.5 0 1 0 8 10a2.5 2.5 0 0 0 0-4.5z"/>
                                        </svg>
                                    </span>
                                    <span class="js-eye-slash d-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M13.359 11.238C14.443 10.131 15.2 8.86 15.2 8.86s-3-5.5-8-5.5c-1.067 0-2.053.252-2.951.642l1.156 1.156A6.34 6.34 0 0 1 7.2 4.36c4.065 0 6.51 3.834 6.51 3.834a13.13 13.13 0 0 1-1.851 2.287l1.5 1.5z"/>
                                            <path d="M3.36 4.762C2.156 5.874 1.2 7.14 1.2 7.14s3 5.5 8 5.5c1.41 0 2.662-.32 3.74-.813l-1.2-1.2a6.75 6.75 0 0 1-2.54.513c-4.065 0-6.51-3.834-6.51-3.834.603-.85 1.33-1.62 2.16-2.27l-1.49-1.49z"/>
                                            <path d="M1.146 1.146a.5.5 0 0 1 .708 0l13 13a.5.5 0 0 1-.708.708l-13-13a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Confirm New Password') }}</label>
                            <div class="input-group">
                                <input id="profile_new_password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                                <button class="btn btn-outline-secondary js-toggle-password" type="button" data-target="#profile_new_password_confirmation" aria-label="Show password">
                                    <span class="js-eye">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                                            <path d="M8 5.5A2.5 2.5 0 1 0 8 10a2.5 2.5 0 0 0 0-4.5z"/>
                                        </svg>
                                    </span>
                                    <span class="js-eye-slash d-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M13.359 11.238C14.443 10.131 15.2 8.86 15.2 8.86s-3-5.5-8-5.5c-1.067 0-2.053.252-2.951.642l1.156 1.156A6.34 6.34 0 0 1 7.2 4.36c4.065 0 6.51 3.834 6.51 3.834a13.13 13.13 0 0 1-1.851 2.287l1.5 1.5z"/>
                                            <path d="M3.36 4.762C2.156 5.874 1.2 7.14 1.2 7.14s3 5.5 8 5.5c1.41 0 2.662-.32 3.74-.813l-1.2-1.2a6.75 6.75 0 0 1-2.54.513c-4.065 0-6.51-3.834-6.51-3.834.603-.85 1.33-1.62 2.16-2.27l-1.49-1.49z"/>
                                            <path d="M1.146 1.146a.5.5 0 0 1 .708 0l13 13a.5.5 0 0 1-.708.708l-13-13a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Recent Orders') }}</h5>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Order Number') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>{{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : 'warning' }}">
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
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">{{ __('View All Orders') }}</a>
                    @else
                    <p>{{ __('You have no orders yet.') }}</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Recent Maintenance Requests') }}</h5>
                </div>
                <div class="card-body">
                    @if($maintenanceRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Request Number') }}</th>
                                    <th>{{ __('Device') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenanceRequests as $request)
                                <tr>
                                    <td>{{ $request->request_number }}</td>
                                    <td>{{ $request->device_name }}</td>
                                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $request->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ $request->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-outline-primary">{{ __('View All Requests') }}</a>
                    @else
                    <p>{{ __('You have no maintenance requests yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
