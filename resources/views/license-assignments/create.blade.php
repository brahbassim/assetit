@extends('layouts.master')

@section('title', __('app.assign_license'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.assign_license')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('license-assignments.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.software_licenses')</label>
                        <select name="license_id" class="form-control @error('license_id') is-invalid @enderror" required>
                            <option value="">@lang('app.select') @lang('app.software_licenses')</option>
                            @foreach($licenses as $license)
                            <option value="{{ $license->id }}" {{ old('license_id') == $license->id ? 'selected' : '' }}>
                                {{ $license->software_name }} ({{ $license->availableSeats() }} @lang('app.available_seats'))
                            </option>
                            @endforeach
                        </select>
                        @error('license_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('app.employee')</label>
                        <select name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required>
                            <option value="">@lang('app.select') @lang('app.employee')</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->full_name }} - {{ $employee->department?->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>@lang('app.assigned_date')</label>
                <input type="date" name="assigned_date" class="form-control" value="{{ old('assigned_date', date('Y-m-d')) }}">
            </div>
            <button type="submit" class="btn btn-primary">@lang('app.assign')</button>
            <a href="{{ route('license-assignments.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
        </form>
    </div>
</div>
@endsection
