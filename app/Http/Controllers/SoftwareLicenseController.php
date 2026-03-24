<?php

namespace App\Http\Controllers;

use App\Models\SoftwareLicense;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\SoftwareLicenseRequest;
use Carbon\Carbon;

class SoftwareLicenseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $vendorId = $request->get('vendor_id');
        
        $licenses = SoftwareLicense::with('vendor')
            ->when($search, function ($query) use ($search) {
                $query->where('software_name', 'like', "%{$search}%");
            })
            ->when($vendorId, function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->latest()
            ->paginate(10);

        $vendors = Vendor::all();
        
        return view('software-licenses.index', compact('licenses', 'search', 'vendors', 'vendorId'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('software-licenses.create', compact('vendors'));
    }

    public function store(SoftwareLicenseRequest $request)
    {
        $license = SoftwareLicense::create($request->validated());
        $this->logAudit('create', $license, 'Created license: ' . $license->software_name);
        
        return redirect()->route('software-licenses.index')->with('success', 'Software license created successfully.');
    }

    public function show(SoftwareLicense $softwareLicense)
    {
        $softwareLicense->load(['vendor', 'licenseAssignments.employee']);
        return view('software-licenses.show', compact('softwareLicense'));
    }

    public function edit(SoftwareLicense $softwareLicense)
    {
        $vendors = Vendor::all();
        return view('software-licenses.edit', compact('softwareLicense', 'vendors'));
    }

    public function update(SoftwareLicenseRequest $request, SoftwareLicense $softwareLicense)
    {
        $softwareLicense->update($request->validated());
        $this->logAudit('update', $softwareLicense, 'Updated license: ' . $softwareLicense->software_name);
        
        return redirect()->route('software-licenses.index')->with('success', 'Software license updated successfully.');
    }

    public function destroy(SoftwareLicense $softwareLicense)
    {
        $this->logAudit('delete', $softwareLicense, 'Deleted license: ' . $softwareLicense->software_name);
        $softwareLicense->delete();
        
        return redirect()->route('software-licenses.index')->with('success', 'Software license deleted successfully.');
    }
}
