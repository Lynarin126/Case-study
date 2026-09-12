<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionManagementController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::query()
            ->when($request->filled('module'), fn ($query) => $query->where('module', $request->string('module')))
            ->when($request->filled('search'), fn ($query) => $query->where('slug', 'like', '%' . $request->string('search') . '%'))
            ->orderBy('module')
            ->orderBy('slug')
            ->get()
            ->groupBy('module');

        $allPermissions = Permission::orderBy('module')->orderBy('slug')->get();
        $modules = Permission::select('module')->distinct()->orderBy('module')->pluck('module');
        $roles = Role::orderBy('name')->get();

        return view('admin.permissions.index', compact('permissions', 'allPermissions', 'modules', 'roles'));
    }
}
