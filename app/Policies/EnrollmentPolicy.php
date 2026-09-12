<?php

namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;

class EnrollmentPolicy
{
    public function view(User $user, Enrollment $enrollment): bool
    {
        return $user->hasPermission('enrollments.view')
            && ($user->hasRole(['super-admin', 'admin', 'support']) || $this->isOwnEnrollment($user, $enrollment));
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('enrollments.create');
    }

    public function update(User $user, Enrollment $enrollment): bool
    {
        return $user->hasPermission('enrollments.update') && $user->hasRole(['super-admin', 'admin']);
    }

    public function delete(User $user, Enrollment $enrollment): bool
    {
        return $user->hasPermission('enrollments.delete') && $user->hasRole(['super-admin', 'admin']);
    }

    private function isOwnEnrollment(User $user, Enrollment $enrollment): bool
    {
        return $enrollment->student?->email === $user->email;
    }
}
