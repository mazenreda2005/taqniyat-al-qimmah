@extends('layouts.app')

@section('title', __('Request Maintenance'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="card-header bg-dark text-white p-4 border-0 position-relative">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(56, 189, 248, 0.15);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1 h4 text-white">{{ __('Request Maintenance Service') }}</h3>
                            <p class="text-light opacity-75 small mb-0">{{ __('Expert diagnosis and software/hardware repair by certified technicians') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    @guest
                    <div class="alert alert-warning rounded-4 p-4 text-center border-0 shadow-sm">
                        <h5 class="fw-bold mb-2">{{ __('Authentication Required') }}</h5>
                        <p class="mb-3 text-secondary">{{ __('You must be logged in to submit a maintenance request.') }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('Login') }}</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">{{ __('Register') }}</a>
                        </div>
                    </div>
                    @else
                    <form action="{{ route('maintenance.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">{{ __('Device Name') }} *</label>
                            <input type="text" name="device_name" class="form-control form-control-lg rounded-3 fs-6" value="{{ old('device_name') }}" placeholder="مثال: MacBook Pro 16 / PC Workstation" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">{{ __('Issue Description') }} *</label>
                            <textarea name="issue_description" class="form-control rounded-3 fs-6" rows="5" placeholder="{{ __('Please describe the technical issue, symptoms, or requested upgrade in detail...') }}" required>{{ old('issue_description') }}</textarea>
                            <div class="form-text text-muted small mt-2">{{ __('Include any error codes, unusual behavior, or specific hardware details.') }}</div>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('home') }}" class="btn btn-light border rounded-pill px-4 py-2 fw-semibold text-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm d-flex align-items-center gap-2">
                                <span>{{ __('Submit Request') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
