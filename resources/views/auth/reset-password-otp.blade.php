@extends('layouts.app')

@section('title', __('Reset Password'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">{{ __('Enter reset code') }}</h4>
                </div>
                <div class="card-body p-5">
                    <p class="text-center text-muted mb-1">
                        {{ __('We have sent a reset code to your email.') }}
                    </p>
                    <p class="text-center fw-bold mb-4">{{ $email ?? '' }}</p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.otp.verify') }}" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Enter the 6-digit code') }}</label>
                            <input type="text" name="code"
                                   class="form-control form-control-lg text-center @error('code') is-invalid @enderror"
                                   value="{{ old('code') }}" maxlength="6" pattern="[0-9]*" inputmode="numeric"
                                   placeholder="000000" required autofocus>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            {{ __('Verify code') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('password.otp.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            {{ __('Resend code') }}
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('password.forgot') }}">{{ __('Change email') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

