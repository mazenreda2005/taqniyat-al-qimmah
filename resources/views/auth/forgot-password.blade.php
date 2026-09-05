@extends('layouts.app')

@section('title', __('Forgot Password'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">{{ __('Forgot Password') }}</h4>
                </div>
                <div class="card-body p-5">
                    <p class="text-center text-muted mb-4">
                        {{ __('Enter your email to receive a reset code (OTP).') }}
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.forgot.send') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            {{ __('Send OTP') }}
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">{{ __('Back to login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

