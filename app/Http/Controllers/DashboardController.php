<?php

namespace App\Http\Controllers;

use App\Models\HardwareAsset;
use App\Models\SoftwareLicense;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Vendor;
use App\Models\AssetCategory;
use App\Models\MaintenanceRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = HardwareAsset::count();
        $totalLicenses = SoftwareLicense::count();
        $assignedAssets = HardwareAsset::where('status', 'assigned')->count();
        $unassignedAssets = HardwareAsset::where('status', 'available')->count();
        $maintenanceAssets = HardwareAsset::where('status', 'maintenance')->count();
        
        $licensesExpiringSoon = SoftwareLicense::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [Carbon::now(), Carbon::now()->addDays(90)])
            ->count();

        $expiring90Days = SoftwareLicense::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [Carbon::now(), Carbon::now()->addDays(90)])
            ->count();
            
        $expiring30Days = SoftwareLicense::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [Carbon::now(), Carbon::now()->addDays(30)])
            ->count();
            
        $expiring7Days = SoftwareLicense::whereNotNull('expiration_date')
            ->whereBetween('expiration_date', [Carbon::now(), Carbon::now()->addDays(7)])
            ->count();

        $assetsByCategory = HardwareAsset::selectRaw('category_id, COUNT(*) as count')
            ->with('category')
            ->groupBy('category_id')
            ->get();

        $assetsByDepartment = Employee::selectRaw('department_id, COUNT(*) as count')
            ->with('department')
            ->groupBy('department_id')
            ->get();

        $licensesByVendor = SoftwareLicense::selectRaw('vendor_id, COUNT(*) as count')
            ->with('vendor')
            ->groupBy('vendor_id')
            ->get();

        $licenseExpirationTimeline = SoftwareLicense::whereNotNull('expiration_date')
            ->orderBy('expiration_date')
            ->limit(20)
            ->get(['id', 'software_name', 'expiration_date']);

        $recentAssets = HardwareAsset::with(['category', 'assignedEmployee'])
            ->latest()
            ->limit(5)
            ->get();

        $recentMaintenance = MaintenanceRecord::with(['asset', 'vendor'])
            ->latest()
            ->limit(5)
            ->get();

        $warrantyExpired = HardwareAsset::whereNotNull('warranty_expiry')
            ->where('warranty_expiry', '<', Carbon::now())
            ->where('status', '!=', 'retired')
            ->count();

        $warrantyExpiringSoon = HardwareAsset::whereNotNull('warranty_expiry')
            ->where('warranty_expiry', '>', Carbon::now())
            ->where('warranty_expiry', '<=', Carbon::now()->addDays(30))
            ->count();

        $lowStockCategories = AssetCategory::with('hardwareAssets')
            ->get()
            ->filter(fn($cat) => $cat->isLowStock());

        return view('dashboard', compact(
            'totalAssets',
            'totalLicenses',
            'assignedAssets',
            'unassignedAssets',
            'maintenanceAssets',
            'licensesExpiringSoon',
            'expiring90Days',
            'expiring30Days',
            'expiring7Days',
            'assetsByCategory',
            'assetsByDepartment',
            'licensesByVendor',
            'licenseExpirationTimeline',
            'recentAssets',
            'recentMaintenance',
            'warrantyExpired',
            'warrantyExpiringSoon',
            'lowStockCategories'
        ));
    }
}
