@extends('layouts.master')

@section('title', $department->name)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $department->name }}</h1>
    <div>
        <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i> @lang('app.edit')
        </a>
        <a href="{{ route('departments.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.details')</h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>@lang('app.id'):</th>
                        <td>{{ $department->id }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.name'):</th>
                        <td>{{ $department->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.description'):</th>
                        <td>{{ $department->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.created_at'):</th>
                        <td>{{ $department->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.updated_at'):</th>
                        <td>{{ $department->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.employees') ({{ $department->employees->count() }})</h6>
            </div>
            <div class="card-body">
                @if($department->employees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>@lang('app.name')</th>
                                <th>@lang('app.job_title')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($department->employees as $employee)
                            <tr>
                                <td>
                                    <a href="{{ route('employees.show', $employee) }}">{{ $employee->full_name }}</a>
                                </td>
                                <td>{{ $employee->job_title ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">@lang('app.no_data')</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
