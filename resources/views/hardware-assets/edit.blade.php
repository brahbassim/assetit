@extends('layouts.master')

@section('title', __('app.edit') . ' ' . __('app.hardware_assets'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.edit') @lang('app.hardware_assets')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('hardware-assets.update', $hardwareAsset) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.asset_tag')</label>
                        <input type="text" name="asset_tag" class="form-control @error('asset_tag') is-invalid @enderror" value="{{ old('asset_tag', $hardwareAsset->asset_tag) }}" required>
                        @error('asset_tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.name')</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $hardwareAsset->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.category')</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $hardwareAsset->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.vendor')</label>
                        <select name="vendor_id" class="form-control">
                            <option value="">@lang('app.select') @lang('app.vendor')</option>
                            @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $hardwareAsset->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.serial_number')</label>
                        <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number', $hardwareAsset->serial_number) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.status')</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="available" {{ $hardwareAsset->status == 'available' ? 'selected' : '' }}>@lang('app.available')</option>
                            <option value="assigned" {{ $hardwareAsset->status == 'assigned' ? 'selected' : '' }}>@lang('app.assigned')</option>
                            <option value="maintenance" {{ $hardwareAsset->status == 'maintenance' ? 'selected' : '' }}>@lang('app.maintenance')</option>
                            <option value="retired" {{ $hardwareAsset->status == 'retired' ? 'selected' : '' }}>@lang('app.retired')</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.purchase_date')</label>
                        <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', $hardwareAsset->purchase_date?->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.purchase_cost')</label>
                        <input type="number" name="purchase_cost" class="form-control" step="0.01" value="{{ old('purchase_cost', $hardwareAsset->purchase_cost) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.warranty_expiry')</label>
                        <input type="date" name="warranty_expiry" class="form-control" value="{{ old('warranty_expiry', $hardwareAsset->warranty_expiry?->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.assign')</label>
                        <select name="assigned_employee_id" class="form-control">
                            <option value="">@lang('app.select') @lang('app.employee')</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ $hardwareAsset->assigned_employee_id == $emp->id ? 'selected' : '' }}>{{ $emp->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('app.notes')</label>
                <textarea name="notes" class="form-control">{{ old('notes', $hardwareAsset->notes) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            <a href="{{ route('hardware-assets.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
        </form>
    </div>
</div>
@endsection
