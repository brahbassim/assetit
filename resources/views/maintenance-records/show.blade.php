@extends('layouts.master')

@section('title', __('app.maintenance_records'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.maintenance_records')</h1>
    <div>
        <a href="{{ route('maintenance-records.edit', $maintenanceRecord) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> @lang('app.edit')</a>
        <a href="{{ route('maintenance-records.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>@lang('app.hardware_assets'):</th><td><a href="{{ route('hardware-assets.show', $maintenanceRecord->asset) }}">{{ $maintenanceRecord->asset->name }}</a></td></tr>
                    <tr><th>@lang('app.maintenance_type'):</th><td><span class="badge badge-info">@lang('app.' . $maintenanceRecord->maintenance_type)</span></td></tr>
                    <tr><th>@lang('app.vendor'):</th><td>{{ $maintenanceRecord->vendor?->name ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.maintenance_date'):</th><td>{{ $maintenanceRecord->maintenance_date?->format('Y-m-d') }}</td></tr>
                    <tr><th>@lang('app.cost'):</th><td>{{ $maintenanceRecord->cost ? '$' . number_format($maintenanceRecord->cost, 2) : 'N/A' }}</td></tr>
                    <tr><th>@lang('app.description'):</th><td>{{ $maintenanceRecord->description ?? 'N/A' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
