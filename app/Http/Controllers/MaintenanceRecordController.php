<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use App\Models\HardwareAsset;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\MaintenanceRecordRequest;

class MaintenanceRecordController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('maintenance_type');
        
        $records = MaintenanceRecord::with(['asset', 'vendor'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('asset', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('asset_tag', 'like', "%{$search}%");
                });
            })
            ->when($type, function ($query) use ($type) {
                $query->where('maintenance_type', $type);
            })
            ->latest()
            ->paginate(10);

        return view('maintenance-records.index', compact('records', 'search', 'type'));
    }

    public function create()
    {
        $assets = HardwareAsset::all();
        $vendors = Vendor::all();
        return view('maintenance-records.create', compact('assets', 'vendors'));
    }

    public function store(MaintenanceRecordRequest $request)
    {
        $record = MaintenanceRecord::create($request->validated());
        
        if ($request->maintenance_type === 'repair') {
            HardwareAsset::find($request->asset_id)->update(['status' => 'maintenance']);
        }
        
        $this->logAudit('create', $record, 'Created maintenance record for asset: ' . $record->asset->name);
        
        return redirect()->route('maintenance-records.index')->with('success', 'Maintenance record created successfully.');
    }

    public function show(MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->load(['asset', 'vendor']);
        return view('maintenance-records.show', compact('maintenanceRecord'));
    }

    public function edit(MaintenanceRecord $maintenanceRecord)
    {
        $assets = HardwareAsset::all();
        $vendors = Vendor::all();
        return view('maintenance-records.edit', compact('maintenanceRecord', 'assets', 'vendors'));
    }

    public function update(MaintenanceRecordRequest $request, MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->update($request->validated());
        $this->logAudit('update', $maintenanceRecord, 'Updated maintenance record: ' . $maintenanceRecord->id);
        
        return redirect()->route('maintenance-records.index')->with('success', 'Maintenance record updated successfully.');
    }

    public function destroy(MaintenanceRecord $maintenanceRecord)
    {
        $this->logAudit('delete', $maintenanceRecord, 'Deleted maintenance record: ' . $maintenanceRecord->id);
        $maintenanceRecord->delete();
        
        return redirect()->route('maintenance-records.index')->with('success', 'Maintenance record deleted successfully.');
    }
}
