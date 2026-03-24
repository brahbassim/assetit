<?php

namespace App\Http\Controllers;

use App\Models\HardwareAsset;
use App\Models\AssetCategory;
use App\Models\Vendor;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\HardwareAssetRequest;

class HardwareAssetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $categoryId = $request->get('category_id');

        $assets = HardwareAsset::with(['category', 'vendor', 'assignedEmployee'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('asset_tag', 'like', "%{$search}%")
                      ->orWhere('serial_number', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(10);

        $categories = AssetCategory::all();
        
        return view('hardware-assets.index', compact('assets', 'search', 'status', 'categories', 'categoryId'));
    }

    public function create()
    {
        $categories = AssetCategory::all();
        $vendors = Vendor::all();
        $employees = Employee::all();
        return view('hardware-assets.create', compact('categories', 'vendors', 'employees'));
    }

    public function store(HardwareAssetRequest $request)
    {
        $asset = HardwareAsset::create($request->validated());
        $this->logAudit('create', $asset, 'Created hardware asset: ' . $asset->name);
        
        return redirect()->route('hardware-assets.index')->with('success', 'Hardware asset created successfully.');
    }

    public function show(HardwareAsset $hardwareAsset)
    {
        $hardwareAsset->load(['category', 'vendor', 'assignedEmployee', 'maintenanceRecords']);
        return view('hardware-assets.show', compact('hardwareAsset'));
    }

    public function edit(HardwareAsset $hardwareAsset)
    {
        $categories = AssetCategory::all();
        $vendors = Vendor::all();
        $employees = Employee::all();
        return view('hardware-assets.edit', compact('hardwareAsset', 'categories', 'vendors', 'employees'));
    }

    public function update(HardwareAssetRequest $request, HardwareAsset $hardwareAsset)
    {
        $oldStatus = $hardwareAsset->status;
        $hardwareAsset->update($request->validated());
        $newStatus = $hardwareAsset->status;
        
        $description = 'Updated hardware asset: ' . $hardwareAsset->name;
        if ($oldStatus !== $newStatus) {
            $description .= ' (Status changed from ' . $oldStatus . ' to ' . $newStatus . ')';
        }
        
        $this->logAudit('update', $hardwareAsset, $description);
        
        return redirect()->route('hardware-assets.index')->with('success', 'Hardware asset updated successfully.');
    }

    public function destroy(HardwareAsset $hardwareAsset)
    {
        $this->logAudit('delete', $hardwareAsset, 'Deleted hardware asset: ' . $hardwareAsset->name);
        $hardwareAsset->delete();
        
        return redirect()->route('hardware-assets.index')->with('success', 'Hardware asset deleted successfully.');
    }

    public function assign(Request $request, HardwareAsset $hardwareAsset)
    {
        $request->validate([
            'assigned_employee_id' => 'required|exists:employees,id',
        ]);

        $hardwareAsset->update([
            'assigned_employee_id' => $request->assigned_employee_id,
            'status' => 'assigned',
        ]);

        $employee = Employee::find($request->assigned_employee_id);
        $this->logAudit('assign', $hardwareAsset, 'Assigned asset to ' . $employee->full_name);

        return redirect()->route('hardware-assets.show', $hardwareAsset)->with('success', 'Asset assigned successfully.');
    }

    public function unassign(HardwareAsset $hardwareAsset)
    {
        $employee = $hardwareAsset->assignedEmployee;
        $hardwareAsset->update([
            'assigned_employee_id' => null,
            'status' => 'available',
        ]);

        $this->logAudit('revoke', $hardwareAsset, 'Unassigned asset from ' . ($employee ? $employee->full_name : 'Unknown'));

        return redirect()->route('hardware-assets.show', $hardwareAsset)->with('success', 'Asset unassigned successfully.');
    }
}
