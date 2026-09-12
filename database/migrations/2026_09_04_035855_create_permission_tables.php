<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        throw_if(empty($tableNames), Exception::class, 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');

        if (! Schema::hasTable($tableNames['permissions'])) {
            Schema::create($tableNames['permissions'], static function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('module')->index();
                $table->text('description')->nullable();
                $table->string('guard_name');
                $table->timestamps();

                $table->unique(['name', 'guard_name']);
            });
        } else {
            Schema::table($tableNames['permissions'], static function (Blueprint $table): void {
                if (! Schema::hasColumn('permissions', 'guard_name')) {
                    $table->string('guard_name')->default('web')->after('name');
                }
                if (! Schema::hasColumn('permissions', 'module')) {
                    $table->string('module')->default('General')->index()->after('slug');
                }
                if (! Schema::hasColumn('permissions', 'description')) {
                    $table->text('description')->nullable()->after('module');
                }
            });

            DB::table($tableNames['permissions'])->whereNull('guard_name')->orWhere('guard_name', '')->update(['guard_name' => 'web']);
            if (Schema::hasColumn($tableNames['permissions'], 'slug')) {
                DB::table($tableNames['permissions'])
                    ->whereNotNull('slug')
                    ->where('slug', '!=', '')
                    ->update(['name' => DB::raw('slug')]);
            }
        }

        if (! Schema::hasTable($tableNames['roles'])) {
            Schema::create($tableNames['roles'], static function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->boolean('is_system')->default(false);
                $table->string('guard_name');
                $table->timestamps();

                $table->unique(['name', 'guard_name']);
            });
        } else {
            Schema::table($tableNames['roles'], static function (Blueprint $table): void {
                if (! Schema::hasColumn('roles', 'guard_name')) {
                    $table->string('guard_name')->default('web')->after('name');
                }
                if (! Schema::hasColumn('roles', 'slug')) {
                    $table->string('slug')->nullable()->unique()->after('name');
                }
                if (! Schema::hasColumn('roles', 'description')) {
                    $table->text('description')->nullable()->after('slug');
                }
                if (! Schema::hasColumn('roles', 'is_system')) {
                    $table->boolean('is_system')->default(false)->after('description');
                }
            });

            DB::table($tableNames['roles'])->whereNull('guard_name')->orWhere('guard_name', '')->update(['guard_name' => 'web']);
            if (Schema::hasColumn($tableNames['roles'], 'slug')) {
                DB::table($tableNames['roles'])
                    ->whereNotNull('slug')
                    ->where('slug', '!=', '')
                    ->update(['name' => DB::raw('slug')]);
            }
        }

        if (! Schema::hasTable($tableNames['model_has_permissions'])) {
            Schema::create($tableNames['model_has_permissions'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission): void {
                $table->unsignedBigInteger($pivotPermission);
                $table->string('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');
                $table->foreign($pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_permission_model_type_primary');
            });
        }

        if (! Schema::hasTable($tableNames['model_has_roles'])) {
            Schema::create($tableNames['model_has_roles'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole): void {
                $table->unsignedBigInteger($pivotRole);
                $table->string('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');
                $table->foreign($pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');
                $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'], 'model_has_roles_role_model_type_primary');
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

        if (Schema::hasTable('role_permissions')) {
            DB::table('role_permissions')->orderBy('id')->each(function ($row) use ($tableNames, $pivotRole, $pivotPermission): void {
                DB::table($tableNames['role_has_permissions'])->updateOrInsert([
                    $pivotPermission => $row->permission_id,
                    $pivotRole => $row->role_id,
                ]);
            });
        }

        if (Schema::hasTable('user_roles')) {
            DB::table('user_roles')->orderBy('id')->each(function ($row) use ($tableNames, $columnNames, $pivotRole): void {
                DB::table($tableNames['model_has_roles'])->updateOrInsert([
                    $pivotRole => $row->role_id,
                    $columnNames['model_morph_key'] => $row->user_id,
                    'model_type' => \App\Models\User::class,
                ]);
            });
        }

        app('cache')
            ->store(config('permission.cache.store') !== 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
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
