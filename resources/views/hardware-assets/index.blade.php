@extends('layouts.master')

@section('title', __('app.hardware_assets'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.hardware_assets')</h1>
    <div>
        <a href="{{ route('import.hardware-assets.form') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2">
            <i class="fas fa-file-import fa-sm text-white-50"></i> @lang('app.import')
        </a>
        <a href="{{ route('hardware-assets.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> @lang('app.create')
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET" action="{{ route('hardware-assets.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="@lang('app.search')..." value="{{ $search ?? '' }}">
            <select name="status" class="form-control mr-2">
                <option value="">@lang('app.all') @lang('app.status')</option>
                <option value="available" {{ $status == 'available' ? 'selected' : '' }}>@lang('app.available')</option>
                <option value="assigned" {{ $status == 'assigned' ? 'selected' : '' }}>@lang('app.assigned')</option>
                <option value="maintenance" {{ $status == 'maintenance' ? 'selected' : '' }}>@lang('app.maintenance')</option>
                <option value="retired" {{ $status == 'retired' ? 'selected' : '' }}>@lang('app.retired')</option>
            </select>
            <select name="category_id" class="form-control mr-2">
                <option value="">@lang('app.all') @lang('app.category')</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">@lang('app.filter')</button>
            @if($search || $status || $categoryId)
            <a href="{{ route('hardware-assets.index') }}" class="btn btn-secondary ml-2">@lang('app.reset')</a>
            @endif
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>@lang('app.asset_tag')</th>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.status')</th>
                        <th>@lang('app.assigned_to')</th>
                        <th>@lang('app.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                    <tr>
                        <td>{{ $asset->asset_tag }}</td>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->category?->name }}</td>
                        <td><span class="badge badge-{{ $asset->status == 'assigned' ? 'success' : ($asset->status == 'maintenance' ? 'warning' : 'primary') }}">@lang('app.' . $asset->status)</span></td>
                        <td>{{ $asset->assignedEmployee?->full_name ?? __('app.unassigned') }}</td>
                        <td>
                            <a href="{{ route('hardware-assets.show', $asset) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('hardware-assets.edit', $asset) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('hardware-assets.destroy', $asset) }}" class="d-inline" onsubmit="return confirm('@lang('app.confirm_delete')');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $assets->links() }}
    </div>
</div>
@endsection
