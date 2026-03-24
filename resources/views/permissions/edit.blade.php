@extends('layouts.master')

@section('title', __('app.edit') . ' ' . __('app.permissions'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.edit') @lang('app.permissions')</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('permissions.update', $permission) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">@lang('app.name')</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $permission->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">@lang('app.save')</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
