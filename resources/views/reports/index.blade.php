@extends('layouts.master')

@section('title', __('app.reports'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.reports')</h1>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.hardware_inventory')</h6>
            </div>
            <div class="card-body">
                <p>Export complete hardware asset inventory including all details.</p>
                <a href="{{ route('reports.hardware-inventory', ['format' => 'pdf']) }}" class="btn btn-primary mb-2">
                    <i class="fas fa-file-pdf"></i> @lang('app.export_pdf')
                </a>
                <a href="{{ route('reports.hardware-inventory', ['format' => 'excel']) }}" class="btn btn-success mb-2">
                    <i class="fas fa-file-excel"></i> @lang('app.export_excel')
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.license_utilization')</h6>
            </div>
            <div class="card-body">
                <p>View license utilization and seat allocation.</p>
                <a href="{{ route('reports.license-utilization', ['format' => 'pdf']) }}" class="btn btn-primary mb-2">
                    <i class="fas fa-file-pdf"></i> @lang('app.export_pdf')
                </a>
                <a href="{{ route('reports.license-utilization', ['format' => 'excel']) }}" class="btn btn-success mb-2">
                    <i class="fas fa-file-excel"></i> @lang('app.export_excel')
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.assets_by_department')</h6>
            </div>
            <div class="card-body">
                <p>View asset distribution across departments.</p>
                <a href="{{ route('reports.assets-by-department', ['format' => 'pdf']) }}" class="btn btn-primary mb-2">
                    <i class="fas fa-file-pdf"></i> @lang('app.export_pdf')
                </a>
                <a href="{{ route('reports.assets-by-department', ['format' => 'excel']) }}" class="btn btn-success mb-2">
                    <i class="fas fa-file-excel"></i> @lang('app.export_excel')
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.maintenance_cost')</h6>
            </div>
            <div class="card-body">
                <p>Track maintenance expenses by year.</p>
                <a href="{{ route('reports.maintenance-cost', ['format' => 'pdf', 'year' => date('Y')]) }}" class="btn btn-primary mb-2">
                    <i class="fas fa-file-pdf"></i> @lang('app.export_pdf')
                </a>
                <a href="{{ route('reports.maintenance-cost', ['format' => 'excel', 'year' => date('Y')]) }}" class="btn btn-success mb-2">
                    <i class="fas fa-file-excel"></i> @lang('app.export_excel')
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.license_expiration')</h6>
            </div>
            <div class="card-body">
                <p>Track expiring and expired licenses.</p>
                <a href="{{ route('reports.license-expiration', ['format' => 'pdf']) }}" class="btn btn-primary mb-2">
                    <i class="fas fa-file-pdf"></i> @lang('app.export_pdf')
                </a>
                <a href="{{ route('reports.license-expiration', ['format' => 'excel']) }}" class="btn btn-success mb-2">
                    <i class="fas fa-file-excel"></i> @lang('app.export_excel')
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
