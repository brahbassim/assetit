@extends('layouts.master')

@section('title', $employee->full_name)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $employee->full_name }}</h1>
    <div>
        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> @lang('app.edit')</a>
        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>@lang('app.name'):</th><td>{{ $employee->full_name }}</td></tr>
                    <tr><th>@lang('app.email'):</th><td>{{ $employee->email }}</td></tr>
                    <tr><th>@lang('app.phone'):</th><td>{{ $employee->phone ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.department'):</th><td>{{ $employee->department?->name }}</td></tr>
                    <tr><th>@lang('app.job_title'):</th><td>{{ $employee->job_title ?? 'N/A' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.hardware_assets') ({{ $employee->hardwareAssets->count() }})</h6></div>
            <div class="card-body">
                @forelse($employee->hardwareAssets as $asset)
                <div class="mb-2">
                    <a href="{{ route('hardware-assets.show', $asset) }}">{{ $asset->name }}</a>
                    <span class="badge badge-{{ $asset->status == 'assigned' ? 'success' : 'warning' }}">@lang('app.' . $asset->status)</span>
                </div>
                @empty
                <p class="text-muted">@lang('app.no_data')</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.license_assignments') ({{ $employee->licenseAssignments->count() }})</h6></div>
    <div class="card-body">
        @forelse($employee->licenseAssignments as $assignment)
        <div class="mb-2">
            <a href="{{ route('software-licenses.show', $assignment->license) }}">{{ $assignment->license->software_name }}</a>
            <span class="badge badge-{{ $assignment->isActive() ? 'success' : 'secondary' }}">
                {{ $assignment->isActive() ? __('app.active') : __('app.inactive') }}
            </span>
            <small class="text-muted">{{ $assignment->assigned_date?->format('Y-m-d') }}</small>
        </div>
        @empty
        <p class="text-muted">@lang('app.no_data')</p>
        @endforelse
    </div>
</div>
@endsection
