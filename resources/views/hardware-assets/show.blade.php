@extends('layouts.master')

@section('title', $hardwareAsset->name)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $hardwareAsset->name }}</h1>
    <div>
        <a href="{{ route('hardware-assets.edit', $hardwareAsset) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> @lang('app.edit')</a>
        <a href="{{ route('hardware-assets.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
    </div>
</div>

@if($hardwareAsset->isWarrantyExpired() || $hardwareAsset->isWarrantyExpiringSoon())
<div class="alert alert-{{ $hardwareAsset->isWarrantyExpired() ? 'danger' : 'warning' }} mb-4">
    <i class="fas fa-exclamation-triangle"></i> 
    @lang('app.warranty_expiry') {{ $hardwareAsset->isWarrantyExpired() ? __('app.expired') : __('app.licenses_expiring_soon') }} - 
    {{ $hardwareAsset->warranty_expiry?->format('Y-m-d') }}
</div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6></div>
            <div class="card-body">
                <table class="table">
                    <tr><th>@lang('app.asset_tag'):</th><td>{{ $hardwareAsset->asset_tag }}</td></tr>
                    <tr><th>@lang('app.name'):</th><td>{{ $hardwareAsset->name }}</td></tr>
                    <tr><th>@lang('app.category'):</th><td>{{ $hardwareAsset->category?->name }}</td></tr>
                    <tr><th>@lang('app.vendor'):</th><td>{{ $hardwareAsset->vendor?->name ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.serial_number'):</th><td>{{ $hardwareAsset->serial_number ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.status'):</th><td><span class="badge badge-{{ $hardwareAsset->status == 'assigned' ? 'success' : ($hardwareAsset->status == 'maintenance' ? 'warning' : 'primary') }}">@lang('app.' . $hardwareAsset->status)</span></td></tr>
                    <tr><th>@lang('app.assigned_to'):</th><td>{{ $hardwareAsset->assignedEmployee?->full_name ?? __('app.unassigned') }}</td></tr>
                    <tr><th>@lang('app.purchase_date'):</th><td>{{ $hardwareAsset->purchase_date?->format('Y-m-d') ?? 'N/A' }}</td></tr>
                    <tr><th>@lang('app.purchase_cost'):</th><td>{{ $hardwareAsset->purchase_cost ? '$' . number_format($hardwareAsset->purchase_cost, 2) : 'N/A' }}</td></tr>
                    <tr><th>@lang('app.warranty_expiry'):</th><td>
                        @if($hardwareAsset->warranty_expiry)
                            <span class="badge badge-{{ $hardwareAsset->warranty_status === 'expired' ? 'danger' : ($hardwareAsset->warranty_status === 'expiring_soon' ? 'warning' : 'success') }}">
                                {{ $hardwareAsset->warranty_expiry->format('Y-m-d') }}
                            </span>
                        @else
                            N/A
                        @endif
                    </td></tr>
                    <tr><th>@lang('app.notes'):</th><td>{{ $hardwareAsset->notes ?? 'N/A' }}</td></tr>
                </table>
                
                @if($hardwareAsset->status != 'retired' && $hardwareAsset->assignedEmployee)
                <form method="POST" action="{{ route('hardware-assets.unassign', $hardwareAsset) }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-warning" onclick="return confirm('@lang('app.confirm_action')')">@lang('app.unassign')</button>
                </form>
                @endif
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.documents') ({{ $hardwareAsset->documents->count() }})</h6></div>
            <div class="card-body">
                <a href="{{ route('hardware-assets.documents.create', $hardwareAsset) }}" class="btn btn-sm btn-primary mb-3">
                    <i class="fas fa-upload"></i> @lang('app.upload')
                </a>
                @forelse($hardwareAsset->documents as $document)
                <div class="border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas {{ $document->file_icon }}"></i> {{ $document->title }}
                        <small class="text-muted d-block">{{ number_format($document->file_size / 1024, 1) }} KB</small>
                    </div>
                    <div>
                        <a href="{{ route('hardware-assets.documents.download', ['hardwareAsset' => $hardwareAsset, 'assetDocument' => $document]) }}" class="btn btn-sm btn-info"><i class="fas fa-download"></i></a>
                        <form method="POST" action="{{ route('hardware-assets.documents.destroy', ['hardwareAsset' => $hardwareAsset, 'assetDocument' => $document]) }}" class="d-inline" onsubmit="return confirm('@lang('app.confirm_delete')')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-muted">@lang('app.no_data')</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">@lang('app.maintenance') ({{ $hardwareAsset->maintenanceRecords->count() }})</h6></div>
            <div class="card-body">
                @forelse($hardwareAsset->maintenanceRecords as $record)
                <div class="border-bottom pb-2 mb-2">
                    <strong>{{ ucfirst($record->maintenance_type) }}</strong> - {{ $record->maintenance_date?->format('Y-m-d') }}<br>
                    <small class="text-muted">{{ $record->description }}</small><br>
                    <small>@lang('app.cost'): {{ $record->cost ? '$' . number_format($record->cost, 2) : 'N/A' }}</small>
                </div>
                @empty
                <p class="text-muted">@lang('app.no_data')</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
