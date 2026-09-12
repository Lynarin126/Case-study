<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleManagementController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::orderBy('module')->orderBy('slug')->get()->groupBy('module');

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        return view('admin.roles.form', [
            'role' => new Role(),
            'permissionGroups' => Permission::orderBy('module')->orderBy('slug')->get()->groupBy('module'),
            'selectedPermissions' => collect(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRole($request);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        $role = Role::create($validated + ['is_system' => false]);
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', 'បានបង្កើតតួនាទីដោយជោគជ័យ។');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.form', [
            'role' => $role,
            'permissionGroups' => Permission::orderBy('module')->orderBy('slug')->get()->groupBy('module'),
            'selectedPermissions' => $role->permissions()->pluck('permissions.id'),
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $this->validateRole($request, $role);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        $role->update($validated);
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', 'បានកែប្រែតួនាទីដោយជោគជ័យ។');
    }

    public function destroy(Role $role)
    {
        abort_if($role->is_system, 422, 'មិនអាចលុបតួនាទីប្រព័ន្ធបានទេ។');
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'បានលុបតួនាទីដោយជោគជ័យ។');
    }

    private function validateRole(Request $request, ?Role $role = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($role?->id)],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('roles', 'slug')->ignore($role?->id)],
            'description' => ['nullable', 'string'],
            'is_system' => ['boolean'],
            'permissions' => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);
    }
}
