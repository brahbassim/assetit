@extends('layouts.master')

@section('title', $vendor->name)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $vendor->name }}</h1>
    <div>
        <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> @lang('app.edit')</a>
        <a href="{{ route('vendors.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>@lang('app.name'):</th><td>{{ $vendor->name }}</td></tr>
                    <tr><th>@lang('app.contact_person'):</th><td>{{ $vendor->contact_person ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.email'):</th><td>{{ $vendor->email ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.phone'):</th><td>{{ $vendor->phone ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.website'):</th><td>{{ $vendor->website ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.address'):</th><td>{{ $vendor->address ?? 'N/A' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.hardware_assets') ({{ $vendor->hardwareAssets->count() }})</h6></div>
            <div class="card-body">
                @forelse($vendor->hardwareAssets as $asset)
                <div class="mb-2"><a href="{{ route('hardware-assets.show', $asset) }}">{{ $asset->name }}</a></div>
                @empty<p class="text-muted">@lang('app.no_data')</p>@endforelse
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.software_licenses') ({{ $vendor->softwareLicenses->count() }})</h6></div>
    <div class="card-body">
        @forelse($vendor->softwareLicenses as $license)
        <div class="mb-2"><a href="{{ route('software-licenses.show', $license) }}">{{ $license->software_name }}</a></div>
        @empty<p class="text-muted">@lang('app.no_data')</p>@endforelse
    </div>
</div>
@endsection
