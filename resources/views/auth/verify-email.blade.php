@extends('layouts.app')

@section('title', __('Verify Your Email'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">{{ __('Enter verification code') }}</h4>
                </div>
                <div class="card-body p-5">
                    <div class="mb-4 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="#667eea" class="mx-auto">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </div>

                    <p class="text-center text-muted mb-4">
                        {{ __('We have sent a verification code to your email.') }}
                    </p>
                    <p class="text-center fw-bold mb-4">{{ $email ?? '' }}</p>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.verify-code') }}" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Enter the 6-digit code') }}</label>
                            <input type="text" name="code" class="form-control form-control-lg text-center @error('code') is-invalid @enderror" value="{{ old('code') }}" maxlength="6" pattern="[0-9]*" inputmode="numeric" placeholder="000000" required autofocus>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            {{ __('Verify') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('verification.resend-code') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            {{ __('Resend code') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
