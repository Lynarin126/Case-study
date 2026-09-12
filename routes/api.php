<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Course\CourseApiController;
use App\Http\Controllers\Api\Course\CourseCategoryApiController;
use App\Http\Controllers\Api\Course\ElearningApiController;
use App\Http\Controllers\Api\Department\DepartmentApiController;
use App\Http\Controllers\Api\Faculty\FacultyApiController;
use App\Http\Controllers\Api\Teacher\TeacherApiController;
use App\Http\Controllers\Api\Student\StudentApiController;
use App\Http\Controllers\Api\User\UserApiController;
use App\Http\Controllers\Api\AcademicYear\AcademicYearApiController;
use App\Http\Controllers\Api\Authorization\PermissionApiController;
use App\Http\Controllers\Api\Authorization\RoleApiController;
use App\Http\Controllers\Api\Authorization\UserRoleApiController;
use App\Http\Controllers\Api\Auth\AuthController;

// -----------------------------------------------------------------------------
// Public E-Learning & Authentication Routes
// -----------------------------------------------------------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public course browsing catalog and lesson previews
Route::get('courses', [CourseApiController::class, 'index'])->name('api.courses.index');
Route::get('courses/{course}', [CourseApiController::class, 'show'])->name('api.courses.show');
Route::get('courses/{course}/lessons', [ElearningApiController::class, 'lessons'])->name('api.courses.lessons');
Route::get('lessons/{lesson}', [ElearningApiController::class, 'showLesson'])->name('api.lessons.show');
Route::get('course-categories', [CourseCategoryApiController::class, 'index'])->name('api.course_categories.index');

// -----------------------------------------------------------------------------
// Authenticated Learner & User Routes
// -----------------------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', function (Request $request) {
        $user = $request->user()->load('roles.permissions');
        $primaryRole = $user->roles->pluck('slug')->first() ?? 'student';

        return [
            'user' => array_merge($user->only(['id', 'name', 'email']), ['role' => $primaryRole]),
            'roles' => $user->roles->pluck('slug')->values(),
            'permissions' => $user->roles->flatMap->permissions->pluck('slug')->unique()->values(),
        ];
    });

    // Student E-Learning progress & enrollment
    Route::get('enrollments', [ElearningApiController::class, 'enrollments'])->name('api.enrollments.index');
    Route::post('courses/{course}/enroll', [ElearningApiController::class, 'enroll'])->name('api.courses.enroll');
    Route::get('courses/{course}/progress', [ElearningApiController::class, 'progress'])->name('api.courses.progress');
    Route::post('lessons/{lesson}/start', [ElearningApiController::class, 'startLesson'])->name('api.lessons.start');
    Route::post('lessons/{lesson}/complete', [ElearningApiController::class, 'completeLesson'])->name('api.lessons.complete');
});

// -----------------------------------------------------------------------------
// Role-Protected Administrative Management Routes
// -----------------------------------------------------------------------------
Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::get('roles', [RoleApiController::class, 'index'])->middleware('permission:roles.view')->name('roles.index');
    Route::post('roles', [RoleApiController::class, 'store'])->middleware('permission:roles.create')->name('roles.store');
    Route::get('roles/{role}', [RoleApiController::class, 'show'])->middleware('permission:roles.view')->name('roles.show');
    Route::put('roles/{role}', [RoleApiController::class, 'update'])->middleware('permission:roles.update')->name('roles.update');
    Route::patch('roles/{role}', [RoleApiController::class, 'update'])->middleware('permission:roles.update');
    Route::delete('roles/{role}', [RoleApiController::class, 'destroy'])->middleware('permission:roles.delete')->name('roles.destroy');
    Route::get('permissions', [PermissionApiController::class, 'index'])->middleware('permission:permissions.view');
    Route::get('roles/{role}/permissions', [PermissionApiController::class, 'rolePermissions'])->middleware('permission:permissions.view');
    Route::put('roles/{role}/permissions', [PermissionApiController::class, 'syncRolePermissions'])->middleware('permission:permissions.assign');
    Route::get('users/{user}/roles', [UserRoleApiController::class, 'index'])->middleware('permission:roles.view');
    Route::post('users/{user}/roles', [UserRoleApiController::class, 'store'])->middleware('permission:roles.update');
    Route::delete('users/{user}/roles/{role}', [UserRoleApiController::class, 'destroy'])->middleware('permission:roles.update');

    Route::apiResource('faculties', FacultyApiController::class);
    Route::apiResource('departments', DepartmentApiController::class);
    Route::post('course-categories', [CourseCategoryApiController::class, 'store'])->middleware('permission:categories.create');
    Route::get('course-categories/{courseCategory}', [CourseCategoryApiController::class, 'show']);
    Route::put('course-categories/{courseCategory}', [CourseCategoryApiController::class, 'update'])->middleware('permission:categories.update');
    Route::delete('course-categories/{courseCategory}', [CourseCategoryApiController::class, 'destroy'])->middleware('permission:categories.delete');

    Route::post('courses', [CourseApiController::class, 'store'])->middleware('permission:courses.create')->name('courses.store');
    Route::put('courses/{course}', [CourseApiController::class, 'update'])->middleware('permission:courses.update')->name('courses.update');
    Route::patch('courses/{course}', [CourseApiController::class, 'update'])->middleware('permission:courses.update')->name('courses.update');
    Route::delete('courses/{course}', [CourseApiController::class, 'destroy'])->middleware('permission:courses.delete')->name('courses.destroy');

    Route::apiResource('teachers', TeacherApiController::class);
    Route::apiResource('students', StudentApiController::class);
    Route::apiResource('users', UserApiController::class);
    Route::apiResource('academic-years', AcademicYearApiController::class);
});
