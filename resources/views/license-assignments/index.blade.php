@extends('layouts.master')

@section('title', __('app.license_assignments'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.license_assignments')</h1>
    <a href="{{ route('license-assignments.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> @lang('app.assign_license')
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>@lang('app.title')</th>
                        <th>@lang('app.employee')</th>
                        <th>@lang('app.assigned_date')</th>
                        <th>@lang('app.status')</th>
                        <th>@lang('app.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>
                            <a href="{{ route('software-licenses.show', $assignment->license) }}">{{ $assignment->license->software_name }}</a>
                        </td>
                        <td>
                            <a href="{{ route('employees.show', $assignment->employee) }}">{{ $assignment->employee->full_name }}</a>
                        </td>
                        <td>{{ $assignment->assigned_date?->format('Y-m-d') }}</td>
                        <td>
                            <span class="badge badge-{{ $assignment->isActive() ? 'success' : 'secondary' }}">
                                {{ $assignment->isActive() ? __('app.active') : __('app.inactive') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('license-assignments.show', $assignment) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            @if($assignment->isActive())
                            <form method="POST" action="{{ route('license-assignments.revoke', $assignment) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('@lang('app.confirm_action')')">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('license-assignments.destroy', $assignment) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('app.confirm_delete')')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $assignments->links() }}
    </div>
</div>
@endsection
