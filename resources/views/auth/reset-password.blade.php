@extends('layouts.app')

@section('title', __('Set New Password'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">{{ __('Set New Password') }}</h4>
                </div>
                <div class="card-body p-5">
                    <p class="text-center text-muted mb-4">
                        {{ __('Set a new password for') }} <span class="fw-bold">{{ $email ?? '' }}</span>
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.reset') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('New Password') }}</label>
                            <div class="input-group">
                                <input id="reset_password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autofocus>
                                <button class="btn btn-outline-secondary js-toggle-password" type="button" data-target="#reset_password" aria-label="Show password">
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
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Confirm New Password') }}</label>
                            <div class="input-group">
                                <input id="reset_password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                                <button class="btn btn-outline-secondary js-toggle-password" type="button" data-target="#reset_password_confirmation" aria-label="Show password">
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

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            {{ __('Reset Password') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

