<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('courses.view');
    }

    public function view(User $user, Course $course): bool
    {
        return $user->hasPermission('courses.view')
            && ($this->canManageAllCourses($user) || $this->isAssignedTeacher($user, $course) || $user->hasRole(['student', 'reviewer', 'support']));
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('courses.create');
    }

    public function update(User $user, Course $course): bool
    {
        return $user->hasPermission('courses.update')
            && ($this->canManageAllCourses($user) || $this->isAssignedTeacher($user, $course));
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->hasPermission('courses.delete') && $this->canManageAllCourses($user);
    }

    public function publish(User $user, Course $course): bool
    {
        return $user->hasPermission('courses.publish')
            && ($this->canManageAllCourses($user) || $this->isAssignedTeacher($user, $course));
    }

    private function canManageAllCourses(User $user): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'course-manager']);
    }

    private function isAssignedTeacher(User $user, Course $course): bool
    {
        return $course->teachers()
            ->where('teachers.email', $user->email)
            ->exists();
    }
}
