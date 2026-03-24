<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\HardwareAssetController;
use App\Http\Controllers\SoftwareLicenseController;
use App\Http\Controllers\LicenseAssignmentController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetDocumentController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ImportController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('asset-categories', AssetCategoryController::class);
    Route::resource('hardware-assets', HardwareAssetController::class);
    Route::post('hardware-assets/{hardwareAsset}/assign', [HardwareAssetController::class, 'assign'])->name('hardware-assets.assign');
    Route::post('hardware-assets/{hardwareAsset}/unassign', [HardwareAssetController::class, 'unassign'])->name('hardware-assets.unassign');

    Route::get('/import/hardware-assets', [ImportController::class, 'hardwareAssetsForm'])->name('import.hardware-assets.form');
    Route::post('/import/hardware-assets', [ImportController::class, 'hardwareAssetsImport'])->name('import.hardware-assets.store');
    Route::get('/import/hardware-assets/template', [ImportController::class, 'downloadHardwareAssetsTemplate'])->name('import.hardware-assets.template');

    Route::get('hardware-assets/{hardwareAsset}/documents', [AssetDocumentController::class, 'index'])->name('hardware-assets.documents.index');
    Route::get('hardware-assets/{hardwareAsset}/documents/create', [AssetDocumentController::class, 'create'])->name('hardware-assets.documents.create');
    Route::post('hardware-assets/{hardwareAsset}/documents', [AssetDocumentController::class, 'store'])->name('hardware-assets.documents.store');
    Route::get('hardware-assets/{hardwareAsset}/documents/{assetDocument}', [AssetDocumentController::class, 'show'])->name('hardware-assets.documents.show');
    Route::get('hardware-assets/{hardwareAsset}/documents/{assetDocument}/download', [AssetDocumentController::class, 'download'])->name('hardware-assets.documents.download');
    Route::delete('hardware-assets/{hardwareAsset}/documents/{assetDocument}', [AssetDocumentController::class, 'destroy'])->name('hardware-assets.documents.destroy');

    Route::resource('software-licenses', SoftwareLicenseController::class);
    Route::get('/import/software-licenses', [ImportController::class, 'softwareLicensesForm'])->name('import.software-licenses.form');
    Route::post('/import/software-licenses', [ImportController::class, 'softwareLicensesImport'])->name('import.software-licenses.store');
    Route::get('/import/software-licenses/template', [ImportController::class, 'downloadSoftwareLicensesTemplate'])->name('import.software-licenses.template');
    Route::resource('license-assignments', LicenseAssignmentController::class);
    Route::post('license-assignments/{licenseAssignment}/revoke', [LicenseAssignmentController::class, 'revoke'])->name('license-assignments.revoke');

    Route::resource('maintenance-records', MaintenanceRecordController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/hardware-inventory', [ReportController::class, 'hardwareInventory'])->name('reports.hardware-inventory');
    Route::get('/reports/license-utilization', [ReportController::class, 'licenseUtilization'])->name('reports.license-utilization');
    Route::get('/reports/assets-by-department', [ReportController::class, 'assetsByDepartment'])->name('reports.assets-by-department');
    Route::get('/reports/maintenance-cost', [ReportController::class, 'maintenanceCost'])->name('reports.maintenance-cost');
    Route::get('/reports/license-expiration', [ReportController::class, 'licenseExpiration'])->name('reports.license-expiration');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
        Route::put('users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.roles');
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });
});
