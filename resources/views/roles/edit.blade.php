@extends('layouts.master')

@section('title', __('app.edit') . ' ' . __('app.roles'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.edit') @lang('app.roles')</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update', $role) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">@lang('app.name')</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" required {{ $role->name === 'Admin' ? 'readonly' : '' }}>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>@lang('app.permissions')</label>
                        @error('permissions')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <div class="row">
                            @foreach($permissions as $group => $groupPermissions)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <strong>{{ ucfirst($group) }}</strong>
                                    </div>
                                    <div class="card-body">
                                        @foreach($groupPermissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" class="form-check-input" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                            <label for="permission_{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">@lang('app.save')</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
