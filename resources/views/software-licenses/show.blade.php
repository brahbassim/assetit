@extends('layouts.master')

@section('title', $softwareLicense->software_name)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $softwareLicense->software_name }}</h1>
    <div>
        <a href="{{ route('license-assignments.create') }}?license_id={{ $softwareLicense->id }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> @lang('app.assign_license')
        </a>
        <a href="{{ route('software-licenses.edit', $softwareLicense) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> @lang('app.edit')</a>
        <a href="{{ route('software-licenses.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>@lang('app.title'):</th><td>{{ $softwareLicense->software_name }}</td></tr>
                    <tr><th>@lang('app.vendor'):</th><td>{{ $softwareLicense->vendor?->name ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.total_seats'):</th><td>{{ $softwareLicense->total_seats }}</td></tr>
                    <tr><th>@lang('app.assigned'):</th><td>{{ $softwareLicense->assignedSeats() }}</td></tr>
                    <tr><th>@lang('app.available'):</th><td>{{ $softwareLicense->availableSeats() }}</td></tr>
                    <tr><th>@lang('app.cost'):</th><td>{{ $softwareLicense->cost ? '$' . number_format($softwareLicense->cost, 2) : 'N/A' }}</td></tr>
                    <tr><th>@lang('app.purchase_date'):</th><td>{{ $softwareLicense->purchase_date?->format('Y-m-d') ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.expiration_date'):</th><td>
                        @if($softwareLicense->expiration_date)
                        <span class="badge badge-{{ $softwareLicense->isExpired() ? 'danger' : ($softwareLicense->isExpiringSoon(30) ? 'warning' : 'success') }}">
                            {{ $softwareLicense->expiration_date->format('Y-m-d') }}
                        </span>
                        @else
                        <span class="badge badge-secondary">Perpetual</span>
                        @endif
                    </td></tr>
                    <tr><th>@lang('app.notes'):</th><td>{{ $softwareLicense->notes ?? 'N/A' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.license_assignments') ({{ $softwareLicense->licenseAssignments->count() }})</h6></div>
            <div class="card-body">
                @forelse($softwareLicense->licenseAssignments as $assignment)
                <div class="border-bottom pb-2 mb-2">
                    <a href="{{ route('employees.show', $assignment->employee) }}">{{ $assignment->employee->full_name }}</a>
                    <span class="badge badge-{{ $assignment->isActive() ? 'success' : 'secondary' }}">
                        {{ $assignment->isActive() ? __('app.active') : __('app.inactive') }}
                    </span><br>
                    <small class="text-muted">
                        @lang('app.assigned_date'): {{ $assignment->assigned_date?->format('Y-m-d') }}
                        @if($assignment->revoked_date)
                        | @lang('app.revoked_date'): {{ $assignment->revoked_date->format('Y-m-d') }}
                        @endif
                    </small>
                </div>
                @empty
                <p class="text-muted">@lang('app.no_data')</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
