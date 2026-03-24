@extends('layouts.master')

@section('title', __('app.vendors'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.vendors')</h1>
    <a href="{{ route('vendors.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> @lang('app.create')
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET" action="{{ route('vendors.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="@lang('app.search')..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-primary">@lang('app.search')</button>
            @if($search)<a href="{{ route('vendors.index') }}" class="btn btn-secondary ml-2">@lang('app.reset')</a>@endif
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%">
                <thead><tr><th>@lang('app.name')</th><th>@lang('app.contact_person')</th><th>@lang('app.email')</th><th>@lang('app.phone')</th><th>@lang('app.actions')</th></tr></thead>
                <tbody>
                    @foreach($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->contact_person ?? 'N/A' }}</td>
                        <td>{{ $vendor->email ?? 'N/A' }}</td>
                        <td>{{ $vendor->phone ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('vendors.destroy', $vendor) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('@lang('app.confirm_delete')')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $vendors->links() }}
    </div>
</div>
@endsection
