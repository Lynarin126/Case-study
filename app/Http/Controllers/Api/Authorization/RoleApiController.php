<?php

namespace App\Http\Controllers\Api\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleApiController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::with('permissions')->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $role = Role::create($validated + ['is_system' => false]);

        return new RoleResource($role->load('permissions'));
    }

    public function show(Role $role)
    {
        return new RoleResource($role->load('permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate($this->rules($role));
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $role->update($validated);

        return new RoleResource($role->load('permissions'));
    }

    public function destroy(Role $role)
    {
        abort_if($role->is_system, 422, 'System roles cannot be deleted.');

        $role->delete();

        return response()->noContent();
    }

    private function rules(?Role $role = null): array
    {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($role?->id)],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('roles', 'slug')->ignore($role?->id)],
            'description' => ['nullable', 'string'],
        ];
    }
}
