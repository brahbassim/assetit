@extends('layouts.master')

@section('title', __('app.create') . ' ' . __('app.maintenance_records'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.create') @lang('app.maintenance_records')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('maintenance-records.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.hardware_assets')</label>
                        <select name="asset_id" class="form-control @error('asset_id') is-invalid @enderror" required>
                            <option value="">@lang('app.select') @lang('app.hardware_assets')</option>
                            @foreach($assets as $asset)
                            <option value="{{ $asset->id }}">{{ $asset->name }} ({{ $asset->asset_tag }})</option>
                            @endforeach
                        </select>
                        @error('asset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.maintenance_type')</label>
                        <select name="maintenance_type" class="form-control @error('maintenance_type') is-invalid @enderror" required>
                            <option value="preventive">@lang('app.preventive')</option>
                            <option value="repair">@lang('app.repair')</option>
                            <option value="upgrade">@lang('app.upgrade')</option>
                            <option value="inspection">@lang('app.inspection')</option>
                        </select>
                        @error('maintenance_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.maintenance_date')</label>
                        <input type="date" name="maintenance_date" class="form-control @error('maintenance_date') is-invalid @enderror" value="{{ old('maintenance_date', date('Y-m-d')) }}" required>
                        @error('maintenance_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.cost')</label>
                        <input type="number" name="cost" class="form-control" step="0.01" value="{{ old('cost') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.vendor')</label>
                        <select name="vendor_id" class="form-control">
                            <option value="">@lang('app.select') @lang('app.vendor')</option>
                            @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('app.description')</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">@lang('app.create')</button>
            <a href="{{ route('maintenance-records.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
        </form>
    </div>
</div>
@endsection
