@extends('layouts.master')

@section('title', __('app.maintenance_records'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.maintenance_records')</h1>
    <a href="{{ route('maintenance-records.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> @lang('app.create')
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET" action="{{ route('maintenance-records.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="@lang('app.search')..." value="{{ $search ?? '' }}">
            <select name="maintenance_type" class="form-control mr-2">
                <option value="">@lang('app.all') @lang('app.maintenance_type')</option>
                <option value="preventive" {{ $type == 'preventive' ? 'selected' : '' }}>@lang('app.preventive')</option>
                <option value="repair" {{ $type == 'repair' ? 'selected' : '' }}>@lang('app.repair')</option>
                <option value="upgrade" {{ $type == 'upgrade' ? 'selected' : '' }}>@lang('app.upgrade')</option>
                <option value="inspection" {{ $type == 'inspection' ? 'selected' : '' }}>@lang('app.inspection')</option>
            </select>
            <button type="submit" class="btn btn-primary">@lang('app.filter')</button>
            @if($search || $type)
            <a href="{{ route('maintenance-records.index') }}" class="btn btn-secondary ml-2">@lang('app.reset')</a>
            @endif
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>@lang('app.hardware_assets')</th>
                        <th>@lang('app.maintenance_type')</th>
                        <th>@lang('app.vendor')</th>
                        <th>@lang('app.maintenance_date')</th>
                        <th>@lang('app.cost')</th>
                        <th>@lang('app.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <tr>
                        <td><a href="{{ route('hardware-assets.show', $record->asset) }}">{{ $record->asset->name }}</a></td>
                        <td><span class="badge badge-info">@lang('app.' . $record->maintenance_type)</span></td>
                        <td>{{ $record->vendor?->name ?? 'N/A' }}</td>
                        <td>{{ $record->maintenance_date?->format('Y-m-d') }}</td>
                        <td>{{ $record->cost ? '$' . number_format($record->cost, 2) : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('maintenance-records.show', $record) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('maintenance-records.edit', $record) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('maintenance-records.destroy', $record) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('app.confirm_delete')')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $records->links() }}
    </div>
</div>
@endsection
