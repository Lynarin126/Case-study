<?php

namespace App\Policies;

use App\Models\CourseModule;
use App\Models\User;

class CourseModulePolicy
{
    public function view(User $user, CourseModule $chapter): bool
    {
        return $user->hasPermission('chapters.view') && $this->canAccessCourse($user, $chapter);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('chapters.create');
    }

    public function update(User $user, CourseModule $chapter): bool
    {
        return $user->hasPermission('chapters.update') && $this->canManageCourse($user, $chapter);
    }

    public function delete(User $user, CourseModule $chapter): bool
    {
        return $user->hasPermission('chapters.delete') && $this->canManageCourse($user, $chapter);
    }

    private function canAccessCourse(User $user, CourseModule $chapter): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'course-manager', 'reviewer', 'support', 'student'])
            || $this->isAssignedTeacher($user, $chapter);
    }

    private function canManageCourse(User $user, CourseModule $chapter): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'course-manager'])
            || $this->isAssignedTeacher($user, $chapter);
    }

    private function isAssignedTeacher(User $user, CourseModule $chapter): bool
    {
        return $chapter->course?->teachers()->where('teachers.email', $user->email)->exists() ?? false;
    }
}
