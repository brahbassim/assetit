@extends('layouts.master')

@section('title', __('app.edit') . ' ' . __('app.asset_categories'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.edit') @lang('app.asset_categories')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('asset-categories.update', $assetCategory) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>@lang('app.name')</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $assetCategory->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>@lang('app.description')</label>
                <textarea name="description" class="form-control">{{ old('description', $assetCategory->description) }}</textarea>
            </div>
            <div class="form-group">
                <label>@lang('app.min_stock')</label>
                <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror" value="{{ old('min_stock', $assetCategory->min_stock) }}" min="0">
                <small class="form-text text-muted">@lang('app.low_stock_alerts')</small>
                @error('min_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            <a href="{{ route('asset-categories.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
        </form>
    </div>
</div>
@endsection
