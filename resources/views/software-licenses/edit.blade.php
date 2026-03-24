@extends('layouts.master')

@section('title', __('app.edit') . ' ' . __('app.software_licenses'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.edit') @lang('app.software_licenses')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('software-licenses.update', $softwareLicense) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.title')</label>
                        <input type="text" name="software_name" class="form-control @error('software_name') is-invalid @enderror" value="{{ old('software_name', $softwareLicense->software_name) }}" required>
                        @error('software_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.vendor')</label>
                        <select name="vendor_id" class="form-control">
                            <option value="">@lang('app.select') @lang('app.vendor')</option>
                            @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $softwareLicense->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('app.license_key')</label>
                <textarea name="license_key" class="form-control">{{ old('license_key', $softwareLicense->license_key) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.total_seats')</label>
                        <input type="number" name="total_seats" class="form-control @error('total_seats') is-invalid @enderror" value="{{ old('total_seats', $softwareLicense->total_seats) }}" required min="1">
                        @error('total_seats')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.cost')</label>
                        <input type="number" name="cost" class="form-control" step="0.01" value="{{ old('cost', $softwareLicense->cost) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.purchase_date')</label>
                        <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', $softwareLicense->purchase_date?->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.expiration_date')</label>
                        <input type="date" name="expiration_date" class="form-control" value="{{ old('expiration_date', $softwareLicense->expiration_date?->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('app.notes')</label>
                <textarea name="notes" class="form-control">{{ old('notes', $softwareLicense->notes) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            <a href="{{ route('software-licenses.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
        </form>
    </div>
</div>
@endsection
