@extends('layouts.master')

@section('title', __('app.audit_logs'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.audit_logs')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="GET" class="d-flex flex-wrap gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('app.search')..." value="{{ request('search') }}">
            <select name="action" class="form-control form-control-sm">
                <option value="">@lang('app.all') @lang('app.actions')</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-primary">@lang('app.filter')</button>
            <a href="{{ route('audit-logs.index') }}" class="btn btn-sm btn-secondary">@lang('app.reset')</a>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@lang('app.id')</th>
                        <th>@lang('app.user')</th>
                        <th>@lang('app.action')</th>
                        <th>@lang('app.model')</th>
                        <th>@lang('app.description')</th>
                        <th>@lang('app.created_at')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user?->name ?? 'System' }}</td>
                        <td>
                            <span class="badge badge-{{ $log->action == 'create' ? 'success' : ($log->action == 'delete' ? 'danger' : ($log->action == 'update' ? 'warning' : 'info')) }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>{{ $log->model_type }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">@lang('app.no_data')</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $auditLogs->links() }}
    </div>
</div>
@endsection
