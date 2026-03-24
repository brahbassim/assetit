@extends('layouts.master')

@section('title', $assetCategory->name)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $assetCategory->name }}</h1>
    <div>
        <a href="{{ route('asset-categories.edit', $assetCategory) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> @lang('app.edit')</a>
        <a href="{{ route('asset-categories.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6></div>
    <div class="card-body">
        <table class="table">
            <tr><th>@lang('app.id'):</th><td>{{ $assetCategory->id }}</td></tr>
            <tr><th>@lang('app.name'):</th><td>{{ $assetCategory->name }}</td></tr>
            <tr><th>@lang('app.description'):</th><td>{{ $assetCategory->description ?? 'N/A' }}</td></tr>
            <tr><th>@lang('app.min_stock'):</th><td>{{ $assetCategory->min_stock ?? 0 }}</td></tr>
            <tr><th>@lang('app.current_stock'):</th><td>
                {{ $assetCategory->hardwareAssets->count() }}
                @if($assetCategory->isLowStock())
                    <span class="badge badge-danger">@lang('app.low_stock')</span>
                @endif
            </td></tr>
        </table>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.hardware_assets')</h6></div>
    <div class="card-body">
        @forelse($assetCategory->hardwareAssets as $asset)
        <div class="mb-2">
            <a href="{{ route('hardware-assets.show', $asset) }}">{{ $asset->name }}</a>
            <span class="badge badge-{{ $asset->status == 'assigned' ? 'success' : ($asset->status == 'maintenance' ? 'warning' : 'primary') }}">@lang('app.' . $asset->status)</span>
        </div>
        @empty
        <p class="text-muted">@lang('app.no_data')</p>
        @endforelse
    </div>
</div>
@endsection
