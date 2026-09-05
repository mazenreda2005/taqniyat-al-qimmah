@extends('layouts.app')

@section('title', __('Maintenance Requests'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ __('My Maintenance Requests') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($requests->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Request Number') }}</th>
                            <th>{{ __('Device Name') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Cost') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->request_number }}</td>
                            <td>{{ $request->device_name }}</td>
                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $request->status === 'completed' ? 'success' : ($request->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ $request->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($request->cost)
                                    {{ number_format($request->cost, 2) }} {{ __('SAR') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#requestModal{{ $request->id }}">
                                    {{ __('View Details') }}
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="requestModal{{ $request->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Request Details') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>{{ __('Request Number:') }}</strong> {{ $request->request_number }}</p>
                                        <p><strong>{{ __('Device Name:') }}</strong> {{ $request->device_name }}</p>
                                        <p><strong>{{ __('Issue Description:') }}</strong></p>
                                        <p>{{ $request->issue_description }}</p>
                                        <p><strong>{{ __('Status:') }}</strong> {{ $request->status_label }}</p>
                                        @if($request->cost)
                                        <p><strong>{{ __('Cost:') }}</strong> {{ number_format($request->cost, 2) }} {{ __('SAR') }}</p>
                                        @endif
                                        @if($request->admin_notes)
                                        <p><strong>{{ __('Admin Notes:') }}</strong> {{ $request->admin_notes }}</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                <p>{{ __('You have no maintenance requests yet.') }}</p>
                <a href="{{ route('maintenance.create') }}" class="btn btn-primary">{{ __('Request Maintenance') }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
