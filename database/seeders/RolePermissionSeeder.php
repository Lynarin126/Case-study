<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissionIds = [];

        foreach (config('lms_permissions.permissions') as $module => $permissions) {
            foreach ($permissions as $permissionSlug) {
                $permission = Permission::updateOrCreate(
                    ['slug' => $permissionSlug],
                    [
                        'name' => Str::headline(str_replace('.', ' ', $permissionSlug)),
                        'module' => $module,
                        'description' => "Allows {$permissionSlug}.",
                    ],
                );

                $permissionIds[$permissionSlug] = $permission->id;
            }
        }

        foreach (config('lms_permissions.roles') as $roleSlug => $roleData) {
            $role = Role::updateOrCreate(
                ['slug' => $roleSlug],
                [
                    'name' => $roleData['name'],
                    'description' => $roleData['description'],
                    'is_system' => true,
                ],
            );

            $slugs = $roleData['permissions'] === ['*']
                ? array_keys($permissionIds)
                : $roleData['permissions'];

            $role->permissions()->sync(
                collect($slugs)->map(fn (string $slug) => $permissionIds[$slug] ?? null)->filter()->values()
            );
        }
    }
}
