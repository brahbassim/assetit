@extends('layouts.master')

@section('title', __('app.show') . ' ' . __('app.users'))

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6>
                <div>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> @lang('app.edit')
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> @lang('app.back')
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p><strong>@lang('app.name'):</strong> {{ $user->name }}</p>
                <p><strong>@lang('app.email'):</strong> {{ $user->email }}</p>
                <p><strong>@lang('app.created_at'):</strong> {{ $user->created_at->format('M d, Y H:i:s') }}</p>
                <p><strong>@lang('app.updated_at'):</strong> {{ $user->updated_at->format('M d, Y H:i:s') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.roles')</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.roles', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        @forelse(\Spatie\Permission\Models\Role::all() as $role)
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}" class="form-check-input" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <label for="role_{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
                        </div>
                        @empty
                        <p class="text-muted">@lang('app.no_data')</p>
                        @endforelse
                    </div>
                    <button type="submit" class="btn btn-primary">@lang('app.save')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
