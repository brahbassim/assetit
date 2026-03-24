<?php

namespace App\Http\Controllers;

use App\Models\LicenseAssignment;
use App\Models\SoftwareLicense;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\LicenseAssignmentRequest;

class LicenseAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $assignments = LicenseAssignment::with(['license', 'employee'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('license', function ($q) use ($search) {
                    $q->where('software_name', 'like', "%{$search}%");
                })->orWhereHas('employee', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('license-assignments.index', compact('assignments', 'search'));
    }

    public function create()
    {
        $licenses = SoftwareLicense::with('vendor')->get()->filter(fn($l) => $l->availableSeats() > 0);
        $employees = Employee::all();
        return view('license-assignments.create', compact('licenses', 'employees'));
    }

    public function store(LicenseAssignmentRequest $request)
    {
        $assignment = LicenseAssignment::create([
            'license_id' => $request->license_id,
            'employee_id' => $request->employee_id,
            'assigned_date' => $request->assigned_date ?? now(),
        ]);

        $license = SoftwareLicense::find($request->license_id);
        $employee = Employee::find($request->employee_id);
        
        $this->logAudit('assign', $assignment, "Assigned license {$license->software_name} to {$employee->full_name}");
        
        return redirect()->route('license-assignments.index')->with('success', 'License assigned successfully.');
    }

    public function show(LicenseAssignment $licenseAssignment)
    {
        $licenseAssignment->load(['license', 'employee']);
        return view('license-assignments.show', compact('licenseAssignment'));
    }

    public function destroy(LicenseAssignment $licenseAssignment)
    {
        $license = $licenseAssignment->license;
        $employee = $licenseAssignment->employee;
        
        $this->logAudit('revoke', $licenseAssignment, "Revoked license {$license->software_name} from {$employee->full_name}");
        $licenseAssignment->delete();
        
        return redirect()->route('license-assignments.index')->with('success', 'License assignment revoked successfully.');
    }

    public function revoke(LicenseAssignment $licenseAssignment)
    {
        $licenseAssignment->update(['revoked_date' => now()]);
        
        $license = $licenseAssignment->license;
        $employee = $licenseAssignment->employee;
        
        $this->logAudit('revoke', $licenseAssignment, "Revoked license {$license->software_name} from {$employee->full_name}");
        
        return redirect()->route('license-assignments.show', $licenseAssignment)->with('success', 'License revoked successfully.');
    }
}
