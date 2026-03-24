<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $departments = Department::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('departments.index', compact('departments', 'search'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(DepartmentRequest $request)
    {
        $department = Department::create($request->validated());
        $this->logAudit('create', $department, 'Created department: ' . $department->name);
        
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load(['employees.hardwareAssets', 'employees.licenseAssignments']);
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        $this->logAudit('update', $department, 'Updated department: ' . $department->name);
        
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $this->logAudit('delete', $department, 'Deleted department: ' . $department->name);
        $department->delete();
        
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
