@extends('layouts.master')

@section('title', __('app.details'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.details')</h1>
    <a href="{{ route('license-assignments.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>@lang('app.software_licenses'):</th><td><a href="{{ route('software-licenses.show', $licenseAssignment->license) }}">{{ $licenseAssignment->license->software_name }}</a></td></tr>
                    <tr><th>@lang('app.employee'):</th><td><a href="{{ route('employees.show', $licenseAssignment->employee) }}">{{ $licenseAssignment->employee->full_name }}</a></td></tr>
                    <tr><th>@lang('app.assigned_date'):</th><td>{{ $licenseAssignment->assigned_date?->format('Y-m-d') }}</td></tr>
                    <tr><th>@lang('app.status'):</th><td>
                        <span class="badge badge-{{ $licenseAssignment->isActive() ? 'success' : 'secondary' }}">
                            {{ $licenseAssignment->isActive() ? __('app.active') : __('app.inactive') }}
                        </span>
                    </td></tr>
                    @if($licenseAssignment->revoked_date)
                    <tr><th>@lang('app.revoked_date'):</th><td>{{ $licenseAssignment->revoked_date->format('Y-m-d') }}</td></tr>
                    @endif
                </table>
                
                @if($licenseAssignment->isActive())
                <form method="POST" action="{{ route('license-assignments.revoke', $licenseAssignment) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning" onclick="return confirm('@lang('app.confirm_action')')">@lang('app.revoke_license')</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
