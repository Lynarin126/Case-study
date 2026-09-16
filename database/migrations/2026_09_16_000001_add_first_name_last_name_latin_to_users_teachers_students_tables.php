<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add columns to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name', 100)->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 100)->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('users', 'first_name_latin')) {
                $table->string('first_name_latin', 100)->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('users', 'last_name_latin')) {
                $table->string('last_name_latin', 100)->nullable()->after('first_name_latin');
            }
        });

        // 2. Add columns to teachers table
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'first_name_latin')) {
                $table->string('first_name_latin', 100)->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('teachers', 'last_name_latin')) {
                $table->string('last_name_latin', 100)->nullable()->after('first_name_latin');
            }
        });

        // 3. Add columns to students table
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'first_name_latin')) {
                $table->string('first_name_latin', 100)->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('students', 'last_name_latin')) {
                $table->string('last_name_latin', 100)->nullable()->after('first_name_latin');
            }
        });

        // 4. Migrate existing user data
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $name = trim($user->name ?? '');
            if (!$name) continue;

            // Extract latin text in parentheses if present, e.g. "សុវណ្ណ សុខ (Sovann Sok)"
            $latinFirst = '';
            $latinLast = '';
            $khmerFirst = '';
            $khmerLast = '';

            if (preg_match('/^(.*?)(?:\((.*?)\))?$/u', $name, $matches)) {
                $mainPart = trim($matches[1] ?? '');
                $parenthesesPart = trim($matches[2] ?? '');

                if ($parenthesesPart !== '') {
                    $parts = preg_split('/\s+/u', $parenthesesPart);
                    $latinFirst = $parts[0] ?? '';
                    $latinLast = implode(' ', array_slice($parts, 1));

                    $mainParts = preg_split('/\s+/u', $mainPart);
                    $khmerFirst = $mainParts[0] ?? '';
                    $khmerLast = implode(' ', array_slice($mainParts, 1));
                } else {
                    $parts = preg_split('/\s+/u', $mainPart);
                    // Check if characters are Khmer
                    if (preg_match('/[\x{1780}-\x{17FF}]/u', $mainPart)) {
                        $khmerFirst = $parts[0] ?? '';
                        $khmerLast = implode(' ', array_slice($parts, 1));
                    } else {
                        $latinFirst = $parts[0] ?? '';
                        $latinLast = implode(' ', array_slice($parts, 1));
                        $khmerFirst = $latinFirst;
                        $khmerLast = $latinLast;
                    }
                }
            }

            DB::table('users')->where('id', $user->id)->update([
                'first_name' => $user->first_name ?: ($khmerFirst ?: 'User'),
                'last_name' => $user->last_name ?: $khmerLast,
                'first_name_latin' => $user->first_name_latin ?: ($latinFirst ?: ($khmerFirst ?: 'User')),
                'last_name_latin' => $user->last_name_latin ?: ($latinLast ?: $khmerLast),
            ]);
        }

        // 5. Migrate existing teacher data
        $teachers = DB::table('teachers')->get();
        foreach ($teachers as $t) {
            $fName = trim($t->first_name ?? '');
            $lName = trim($t->last_name ?? '');

            $latinFirst = '';
            $latinLast = '';
            $cleanKhmerLast = $lName;

            if (preg_match('/^(.*?)(?:\((.*?)\))?$/u', $lName, $matches)) {
                $cleanKhmerLast = trim($matches[1] ?? '');
                $parenthesesPart = trim($matches[2] ?? '');
                if ($parenthesesPart !== '') {
                    $parts = preg_split('/\s+/u', $parenthesesPart);
                    $latinFirst = $parts[0] ?? '';
                    $latinLast = implode(' ', array_slice($parts, 1));
                }
            }

            if (!$latinFirst && $fName) {
                $latinFirst = $fName;
                $latinLast = $cleanKhmerLast;
            }

            DB::table('teachers')->where('teacher_id', $t->teacher_id)->update([
                'last_name' => $cleanKhmerLast,
                'first_name_latin' => $t->first_name_latin ?: $latinFirst,
                'last_name_latin' => $t->last_name_latin ?: $latinLast,
            ]);
        }

        // 6. Migrate existing student data
        $students = DB::table('students')->get();
        foreach ($students as $s) {
            $fName = trim($s->first_name ?? '');
            $lName = trim($s->last_name ?? '');

            $latinFirst = '';
            $latinLast = '';
            $cleanKhmerLast = $lName;

            if (preg_match('/^(.*?)(?:\((.*?)\))?$/u', $lName, $matches)) {
                $cleanKhmerLast = trim($matches[1] ?? '');
                $parenthesesPart = trim($matches[2] ?? '');
                if ($parenthesesPart !== '') {
                    $parts = preg_split('/\s+/u', $parenthesesPart);
                    $latinFirst = $parts[0] ?? '';
                    $latinLast = implode(' ', array_slice($parts, 1));
                }
            }

            if (!$latinFirst && $fName) {
                $latinFirst = $fName;
                $latinLast = $cleanKhmerLast;
            }

            DB::table('students')->where('student_id', $s->student_id)->update([
                'last_name' => $cleanKhmerLast,
                'first_name_latin' => $s->first_name_latin ?: $latinFirst,
                'last_name_latin' => $s->last_name_latin ?: $latinLast,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'first_name_latin', 'last_name_latin']);
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['first_name_latin', 'last_name_latin']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['first_name_latin', 'last_name_latin']);
        });
    }
};
