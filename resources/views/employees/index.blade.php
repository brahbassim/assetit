@extends('layouts.master')

@section('title', __('app.employees'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.employees')</h1>
    <a href="{{ route('employees.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> @lang('app.create')
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET" action="{{ route('employees.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="@lang('app.search')..." value="{{ $search ?? '' }}">
            <select name="department_id" class="form-control mr-2">
                <option value="">@lang('app.all') @lang('app.departments')</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ $departmentId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">@lang('app.filter')</button>
            @if($search || $departmentId)
            <a href="{{ route('employees.index') }}" class="btn btn-secondary ml-2">@lang('app.reset')</a>
            @endif
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.email')</th>
                        <th>@lang('app.department')</th>
                        <th>@lang('app.job_title')</th>
                        <th>@lang('app.phone')</th>
                        <th>@lang('app.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->full_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->department?->name }}</td>
                        <td>{{ $employee->job_title ?? 'N/A' }}</td>
                        <td>{{ $employee->phone ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('employees.destroy', $employee) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('app.confirm_delete')')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $employees->links() }}
    </div>
</div>
@endsection
