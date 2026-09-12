<?php

namespace App\Http\Controllers\Api\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionApiController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::query()
            ->when($request->filled('module'), fn ($query) => $query->where('module', $request->string('module')))
            ->when($request->filled('search'), fn ($query) => $query->where('slug', 'like', '%' . $request->string('search') . '%'))
            ->orderBy('module')
            ->orderBy('slug')
            ->get();

        return PermissionResource::collection($permissions);
    }

    public function rolePermissions(Role $role)
    {
        return PermissionResource::collection($role->permissions()->orderBy('module')->orderBy('slug')->get());
    }

    public function syncRolePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return new \App\Http\Resources\RoleResource($role->load('permissions'));
    }
}
