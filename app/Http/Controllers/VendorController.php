<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\VendorRequest;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $vendors = Vendor::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('vendors.index', compact('vendors', 'search'));
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function store(VendorRequest $request)
    {
        $vendor = Vendor::create($request->validated());
        $this->logAudit('create', $vendor, 'Created vendor: ' . $vendor->name);
        
        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['hardwareAssets', 'softwareLicenses', 'maintenanceRecords']);
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(VendorRequest $request, Vendor $vendor)
    {
        $vendor->update($request->validated());
        $this->logAudit('update', $vendor, 'Updated vendor: ' . $vendor->name);
        
        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $this->logAudit('delete', $vendor, 'Deleted vendor: ' . $vendor->name);
        $vendor->delete();
        
        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
