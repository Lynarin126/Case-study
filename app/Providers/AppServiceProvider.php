<?php

namespace App\Providers;

use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Enrollment;
use App\Models\Student;
use App\Policies\ContentLessonPolicy;
use App\Policies\CoursePolicy;
use App\Policies\CourseModulePolicy;
use App\Policies\EnrollmentPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(CourseModule::class, CourseModulePolicy::class);
        Gate::policy(ContentLesson::class, ContentLessonPolicy::class);
        Gate::policy(Enrollment::class, EnrollmentPolicy::class);
        Gate::policy(Student::class, StudentPolicy::class);

        Gate::before(function ($user, string $ability, ?array $arguments = null) {
            if (! str_contains($ability, '.') || ! empty($arguments)) {
                return null;
            }

            return $user->hasPermission($ability) ?: null;
        });
    }
}
