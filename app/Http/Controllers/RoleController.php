<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $roles = Role::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('roles.index', compact('roles', 'search'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($item) {
            return explode(' ', $item->name)[0];
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);
        $role->syncPermissions($validated['permissions']);
        
        $this->logAudit('create', $role, 'Created role: ' . $role->name);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($item) {
            return explode(' ', $item->name)[0];
        });
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);
        
        $this->logAudit('update', $role, 'Updated role: ' . $role->name);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')->with('error', 'Cannot delete Admin role.');
        }
        
        $roleName = $role->name;
        $role->delete();
        
        $this->logAudit('delete', null, 'Deleted role: ' . $roleName);

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
