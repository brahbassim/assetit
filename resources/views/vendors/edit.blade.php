@extends('layouts.master')

@section('title', __('app.edit') . ' ' . __('app.vendors'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.edit') @lang('app.vendors')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('vendors.update', $vendor) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.name')</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $vendor->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.contact_person')</label>
                        <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $vendor->contact_person) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.email')</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $vendor->email) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.phone')</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $vendor->phone) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.website')</label>
                        <input type="text" name="website" class="form-control" value="{{ old('website', $vendor->website) }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('app.address')</label>
                <textarea name="address" class="form-control">{{ old('address', $vendor->address) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
        </form>
    </div>
</div>
@endsection
