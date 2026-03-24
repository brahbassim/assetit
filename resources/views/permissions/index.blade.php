@extends('layouts.master')

@section('title', __('app.permissions'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.permissions')</h6>
                <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> @lang('app.create')
                </a>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('permissions.index') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="@lang('app.search')..." value="{{ $search ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>@lang('app.name')</th>
                                <th>@lang('app.guard_name')</th>
                                <th>@lang('app.roles')</th>
                                <th>@lang('app.created_at')</th>
                                <th>@lang('app.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                <td>
                                    @foreach($permission->roles->take(3) as $role)
                                        <span class="badge badge-primary">{{ $role->name }}</span>
                                    @endforeach
                                    @if($permission->roles->count() > 3)
                                        <span class="badge badge-secondary">+{{ $permission->roles->count() - 3 }}</span>
                                    @endif
                                </td>
                                <td>{{ $permission->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('permissions.show', $permission) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('permissions.destroy', $permission) }}" class="d-inline" onsubmit="return confirm('@lang('app.confirm_delete')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
