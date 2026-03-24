@extends('layouts.master')

@section('title', __('app.departments'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.departments')</h1>
    <a href="{{ route('departments.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> @lang('app.create')
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET" action="{{ route('departments.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="@lang('app.search')..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-primary">@lang('app.search')</button>
            @if($search)
            <a href="{{ route('departments.index') }}" class="btn btn-secondary ml-2">@lang('app.reset')</a>
            @endif
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@lang('app.id')</th>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.description')</th>
                        <th>@lang('app.created_at')</th>
                        <th>@lang('app.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ Str::limit($department->description, 50) }}</td>
                        <td>{{ $department->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('departments.destroy', $department) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('app.confirm_delete')')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $departments->links() }}
    </div>
</div>
@endsection
