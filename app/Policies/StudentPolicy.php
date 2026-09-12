<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function view(User $user, Student $student): bool
    {
        return $user->hasPermission('students.view')
            && ($user->hasRole(['super-admin', 'admin', 'support']) || $student->email === $user->email);
    }

    public function update(User $user, Student $student): bool
    {
        return $user->hasPermission('students.update')
            && ($user->hasRole(['super-admin', 'admin', 'support']) || $student->email === $user->email);
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasPermission('students.delete') && $user->hasRole(['super-admin', 'admin']);
    }
}
