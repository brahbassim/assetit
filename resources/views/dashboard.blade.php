@extends('layouts.master')

@section('title', __('app.dashboard'))

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.dashboard')</h1>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">@lang('app.total_assets')</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAssets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-desktop fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">@lang('app.total_licenses')</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLicenses }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-key fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('app.assigned_assets')</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $assignedAssets }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">@lang('app.licenses_expiring_soon')</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $licensesExpiringSoon }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($expiring7Days > 0 || $expiring30Days > 0 || $expiring90Days > 0 || $warrantyExpired > 0 || $warrantyExpiringSoon > 0 || $lowStockCategories->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card border-left-danger shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-bell"></i> @lang('app.alerts')
                </h6>
            </div>
            <div class="card-body">
                @if($expiring7Days > 0)
                <div class="alert alert-danger">
                    <strong>{{ $expiring7Days }}</strong> license(s) expiring in <strong>7 days</strong>!
                </div>
                @endif
                @if($expiring30Days > 0)
                <div class="alert alert-warning">
                    <strong>{{ $expiring30Days }}</strong> license(s) expiring in <strong>30 days</strong>.
                </div>
                @endif
                @if($expiring90Days > 0)
                <div class="alert alert-info">
                    <strong>{{ $expiring90Days }}</strong> license(s) expiring in <strong>90 days</strong>.
                </div>
                @endif
                @if($warrantyExpired > 0)
                <div class="alert alert-danger">
                    <strong>{{ $warrantyExpired }}</strong> hardware asset(s) with <strong>expired warranty</strong>!
                </div>
                @endif
                @if($warrantyExpiringSoon > 0)
                <div class="alert alert-warning">
                    <strong>{{ $warrantyExpiringSoon }}</strong> hardware asset(s) with warranty <strong>expiring in 30 days</strong>.
                </div>
                @endif
                @if($lowStockCategories->count() > 0)
                <div class="alert alert-danger">
                    <strong>{{ $lowStockCategories->count() }}</strong> category(s) with <strong>low stock</strong>:
                    {{ $lowStockCategories->pluck('name')->implode(', ') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.assets_by_category')</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="assetsByCategoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.assets_by_department')</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="assetsByDepartmentChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.licenses_by_vendor')</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="licensesByVendorChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.license_expiration_timeline')</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="licenseExpirationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.recent_assets')</h6>
            </div>
            <div class="card-body">
                @foreach($recentAssets as $asset)
                <div class="d-flex align-items-center mb-3">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-desktop text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-weight-bold">{{ $asset->name }}</div>
                        <div class="small text-gray-500">{{ $asset->asset_tag }} | {{ $asset->category?->name }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.recent_maintenance')</h6>
            </div>
            <div class="card-body">
                @foreach($recentMaintenance as $record)
                <div class="d-flex align-items-center mb-3">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-tools text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-weight-bold">{{ $record->asset->name }}</div>
                        <div class="small text-gray-500">{{ $record->maintenance_type }} | {{ $record->maintenance_date?->format('Y-m-d') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('assetsByCategoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($assetsByCategory->pluck('category.name')) !!},
            datasets: [{
                label: '@lang('app.assets')',
                data: {!! json_encode($assetsByCategory->pluck('count')) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    var ctx2 = document.getElementById('assetsByDepartmentChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($assetsByDepartment->pluck('department.name')) !!},
            datasets: [{
                data: {!! json_encode($assetsByDepartment->pluck('count')) !!},
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#858796', '#5a5c69', '#3a3b45', '#2c3e50', '#17a673'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    var ctx3 = document.getElementById('licensesByVendorChart').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: {!! json_encode($licensesByVendor->pluck('vendor.name')->filter()) !!},
            datasets: [{
                label: '@lang('app.licenses')',
                data: {!! json_encode($licensesByVendor->pluck('count')) !!},
                backgroundColor: 'rgba(28, 200, 138, 0.8)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true }
            }
        }
    });

    var ctx4 = document.getElementById('licenseExpirationChart').getContext('2d');
    new Chart(ctx4, {
        type: 'line',
        data: {
            labels: {!! json_encode($licenseExpirationTimeline->pluck('software_name')) !!},
            datasets: [{
                label: '@lang('app.days_until_expiration')',
                data: {!! json_encode($licenseExpirationTimeline->map(fn($l) => \Carbon\Carbon::now()->diffInDays($l->expiration_date, false))->values()) !!},
                backgroundColor: 'rgba(246, 194, 62, 0.2)',
                borderColor: 'rgba(246, 194, 62, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endsection
