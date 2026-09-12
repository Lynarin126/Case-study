<?php

namespace App\Http\Controllers\Api\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleApiController extends Controller
{
    public function index(User $user)
    {
        return RoleResource::collection($user->roles()->with('permissions')->get());
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user->roles()->syncWithoutDetaching($validated['roles']);

        return RoleResource::collection($user->roles()->with('permissions')->get());
    }

    public function destroy(User $user, Role $role)
    {
        $user->roles()->detach($role->id);

        return response()->noContent();
    }
}
