@extends('layouts.master')

@section('title', __('app.profile'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.profile')</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="name">@lang('app.name')</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">@lang('app.email')</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>@lang('app.roles')</label>
                        <div class="form-control" style="background-color: #f8f9fa;">
                            @forelse($user->roles as $role)
                                <span class="badge badge-primary">{{ $role->name }}</span>
                            @empty
                                <span class="text-muted">@lang('app.no_data')</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('app.permissions')</label>
                        <div class="form-control" style="background-color: #f8f9fa; max-height: 150px; overflow-y: auto;">
                            @forelse($user->getAllPermissions() as $permission)
                                <span class="badge badge-info">{{ $permission->name }}</span>
                            @empty
                                <span class="text-muted">@lang('app.no_data')</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">@lang('app.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.info')</h6>
            </div>
            <div class="card-body">
                <p><strong>@lang('app.created_at'):</strong><br>{{ $user->created_at->format('M d, Y') }}</p>
                <p><strong>@lang('app.updated_at'):</strong><br>{{ $user->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
