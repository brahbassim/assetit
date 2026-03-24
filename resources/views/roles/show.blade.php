@extends('layouts.master')

@section('title', __('app.show') . ' ' . __('app.roles'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6>
                <div>
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> @lang('app.edit')
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> @lang('app.back')
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>@lang('app.name'):</strong> {{ $role->name }}</p>
                        <p><strong>@lang('app.guard_name'):</strong> {{ $role->guard_name }}</p>
                        <p><strong>@lang('app.created_at'):</strong> {{ $role->created_at->format('M d, Y H:i:s') }}</p>
                    </div>
                </div>
                
                <h5 class="mt-4">@lang('app.permissions') ({{ $role->permissions->count() }})</h5>
                <div class="mt-2">
                    @forelse($role->permissions as $permission)
                        <span class="badge badge-info badge-lg">{{ $permission->name }}</span>
                    @empty
                        <p class="text-muted">@lang('app.no_data')</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
