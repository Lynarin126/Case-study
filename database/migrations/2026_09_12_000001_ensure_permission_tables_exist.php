<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';
        $modelMorphKey = $columnNames['model_morph_key'] ?? 'model_id';

        if (! Schema::hasTable($tableNames['permissions'])) {
            Schema::create($tableNames['permissions'], static function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('module')->index();
                $table->text('description')->nullable();
                $table->string('guard_name')->default('web');
                $table->timestamps();

                $table->unique(['name', 'guard_name']);
            });
        }

        if (! Schema::hasTable($tableNames['roles'])) {
            Schema::create($tableNames['roles'], static function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->boolean('is_system')->default(false);
                $table->string('guard_name')->default('web');
                $table->timestamps();

                $table->unique(['name', 'guard_name']);
            });
        }

        if (! Schema::hasTable($tableNames['model_has_permissions'])) {
            Schema::create($tableNames['model_has_permissions'], static function (Blueprint $table) use ($tableNames, $modelMorphKey, $pivotPermission): void {
                $table->unsignedBigInteger($pivotPermission);
                $table->string('model_type');
                $table->unsignedBigInteger($modelMorphKey);
                $table->index([$modelMorphKey, 'model_type'], 'model_has_permissions_model_id_model_type_index');
                $table->foreign($pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                $table->primary([$pivotPermission, $modelMorphKey, 'model_type'], 'model_has_permissions_permission_model_type_primary');
            });
        }

        if (! Schema::hasTable($tableNames['model_has_roles'])) {
            Schema::create($tableNames['model_has_roles'], static function (Blueprint $table) use ($tableNames, $modelMorphKey, $pivotRole): void {
                $table->unsignedBigInteger($pivotRole);
                $table->string('model_type');
                $table->unsignedBigInteger($modelMorphKey);
                $table->index([$modelMorphKey, 'model_type'], 'model_has_roles_model_id_model_type_index');
                $table->foreign($pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');
                $table->primary([$pivotRole, $modelMorphKey, 'model_type'], 'model_has_roles_role_model_type_primary');
            });
        }

        if (! Schema::hasTable($tableNames['role_has_permissions'])) {
            Schema::create($tableNames['role_has_permissions'], static function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission): void {
                $table->unsignedBigInteger($pivotPermission);
                $table->unsignedBigInteger($pivotRole);
                $table->foreign($pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                $table->foreign($pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');
                $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
            });
        }

        if (! Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', static function (Blueprint $table) use ($tableNames): void {
                $table->id();
                $table->foreignId('role_id')->constrained($tableNames['roles'])->cascadeOnDelete();
                $table->foreignId('permission_id')->constrained($tableNames['permissions'])->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['role_id', 'permission_id']);
            });
        }

        if (! Schema::hasTable('user_roles')) {
            Schema::create('user_roles', static function (Blueprint $table) use ($tableNames): void {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('role_id')->constrained($tableNames['roles'])->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['user_id', 'role_id']);
            });
        }
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');

        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
};
