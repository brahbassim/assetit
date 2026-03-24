<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $permissions = Permission::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('permissions.index', compact('permissions', 'search'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        Permission::create(['name' => $validated['name'], 'guard_name' => 'web']);
        
        $this->logAudit('create', null, 'Created permission: ' . $validated['name']);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permission->id)],
        ]);

        $permission->update(['name' => $validated['name']]);
        
        $this->logAudit('update', $permission, 'Updated permission: ' . $permission->name);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permissionName = $permission->name;
        $permission->delete();
        
        $this->logAudit('delete', null, 'Deleted permission: ' . $permissionName);

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
