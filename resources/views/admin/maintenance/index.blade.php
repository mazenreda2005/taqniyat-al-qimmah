@extends('layouts.app')

@section('title', __('Maintenance Requests'))

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1>{{ __('Maintenance Requests') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Request Number') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Device') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->request_number }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->device_name }}</td>
                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $request->status === 'completed' ? 'success' : ($request->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ $request->status_label }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.maintenance.show', $request) }}" class="btn btn-sm btn-primary">{{ __('View') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
