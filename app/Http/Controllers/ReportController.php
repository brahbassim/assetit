<?php

namespace App\Http\Controllers;

use App\Models\HardwareAsset;
use App\Models\SoftwareLicense;
use App\Models\Employee;
use App\Models\MaintenanceRecord;
use App\Models\Department;
use App\Models\LicenseAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HardwareInventoryExport;
use App\Exports\LicenseUtilizationExport;
use App\Exports\AssetsByDepartmentExport;
use App\Exports\MaintenanceCostExport;
use App\Exports\LicenseExpirationExport;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function hardwareInventory(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $assets = HardwareAsset::with(['category', 'vendor', 'assignedEmployee'])->get();
        
        if ($format === 'excel') {
            return Excel::download(new HardwareInventoryExport($assets), 'hardware_inventory_' . date('Ymd') . '.xlsx');
        }

        $pdf = Pdf::loadView('reports.hardware-inventory-pdf', compact('assets'));
        return $pdf->download('hardware_inventory_' . date('Ymd') . '.pdf');
    }

    public function licenseUtilization(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $licenses = SoftwareLicense::with(['vendor', 'licenseAssignments'])->get();
        
        if ($format === 'excel') {
            return Excel::download(new LicenseUtilizationExport($licenses), 'license_utilization_' . date('Ymd') . '.xlsx');
        }

        $pdf = Pdf::loadView('reports.license-utilization-pdf', compact('licenses'));
        return $pdf->download('license_utilization_' . date('Ymd') . '.pdf');
    }

    public function assetsByDepartment(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $departments = Department::with(['employees', 'employees.hardwareAssets'])->get();
        
        if ($format === 'excel') {
            return Excel::download(new AssetsByDepartmentExport($departments), 'assets_by_department_' . date('Ymd') . '.xlsx');
        }

        $pdf = Pdf::loadView('reports.assets-by-department-pdf', compact('departments'));
        return $pdf->download('assets_by_department_' . date('Ymd') . '.pdf');
    }

    public function maintenanceCost(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $year = $request->get('year', Carbon::now()->year);
        
        $records = MaintenanceRecord::with(['asset', 'vendor'])
            ->whereYear('maintenance_date', $year)
            ->get();
        
        $totalCost = $records->sum('cost');
        
        if ($format === 'excel') {
            return Excel::download(new MaintenanceCostExport($records, $year, $totalCost), 'maintenance_cost_' . $year . '.xlsx');
        }

        $pdf = Pdf::loadView('reports.maintenance-cost-pdf', compact('records', 'year', 'totalCost'));
        return $pdf->download('maintenance_cost_' . $year . '.pdf');
    }

    public function licenseExpiration(Request $request)
    {
        $format = $request->get('format', 'pdf');
        
        $licenses = SoftwareLicense::whereNotNull('expiration_date')
            ->orderBy('expiration_date')
            ->get();
        
        $expired = $licenses->filter(fn($l) => $l->isExpired());
        $expiringSoon = $licenses->filter(fn($l) => $l->isExpiringSoon(90) && !$l->isExpired());
        $valid = $licenses->filter(fn($l) => !$l->isExpired() && !$l->isExpiringSoon(90));

        if ($format === 'excel') {
            return Excel::download(new LicenseExpirationExport($licenses, $expired, $expiringSoon, $valid), 'license_expiration_' . date('Ymd') . '.xlsx');
        }

        $pdf = Pdf::loadView('reports.license-expiration-pdf', compact('licenses', 'expired', 'expiringSoon', 'valid'));
        return $pdf->download('license_expiration_' . date('Ymd') . '.pdf');
    }
}
