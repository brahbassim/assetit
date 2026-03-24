@extends('layouts.master')

@section('title', __('app.software_licenses'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.software_licenses')</h1>
    <div>
        <a href="{{ route('import.software-licenses.form') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2">
            <i class="fas fa-file-import fa-sm text-white-50"></i> @lang('app.import')
        </a>
        <a href="{{ route('software-licenses.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> @lang('app.create')
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET" action="{{ route('software-licenses.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="@lang('app.search')..." value="{{ $search ?? '' }}">
            <select name="vendor_id" class="form-control mr-2">
                <option value="">@lang('app.all') @lang('app.vendors')</option>
                @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" {{ $vendorId == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">@lang('app.filter')</button>
            @if($search || $vendorId)
            <a href="{{ route('software-licenses.index') }}" class="btn btn-secondary ml-2">@lang('app.reset')</a>
            @endif
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>@lang('app.title')</th>
                        <th>@lang('app.vendor')</th>
                        <th>@lang('app.total_seats')</th>
                        <th>@lang('app.assigned')</th>
                        <th>@lang('app.available')</th>
                        <th>@lang('app.expiration_date')</th>
                        <th>@lang('app.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($licenses as $license)
                    <tr>
                        <td>{{ $license->software_name }}</td>
                        <td>{{ $license->vendor?->name ?? 'N/A' }}</td>
                        <td>{{ $license->total_seats }}</td>
                        <td>{{ $license->assignedSeats() }}</td>
                        <td>{{ $license->availableSeats() }}</td>
                        <td>
                            @if($license->expiration_date)
                            <span class="badge badge-{{ $license->isExpired() ? 'danger' : ($license->isExpiringSoon(30) ? 'warning' : 'success') }}">
                                {{ $license->expiration_date->format('Y-m-d') }}
                            </span>
                            @else
                            <span class="badge badge-secondary">Perpetual</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('software-licenses.show', $license) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('software-licenses.edit', $license) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('software-licenses.destroy', $license) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('app.confirm_delete')')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $licenses->links() }}
    </div>
</div>
@endsection
