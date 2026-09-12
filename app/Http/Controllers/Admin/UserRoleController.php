<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function edit(User $user)
    {
        return view('admin.users.roles', [
            'user' => $user->load('roles'),
            'roles' => Role::orderBy('name')->get(),
            'selectedRoles' => $user->roles->pluck('id'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => ['array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->route('admin.users.roles.edit', $user)->with('success', 'បានកែប្រែតួនាទីអ្នកប្រើប្រាស់ដោយជោគជ័យ។');
    }
}
