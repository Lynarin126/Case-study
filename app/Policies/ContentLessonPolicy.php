<?php

namespace App\Policies;

use App\Models\ContentLesson;
use App\Models\User;

class ContentLessonPolicy
{
    public function view(User $user, ContentLesson $content): bool
    {
        return $user->hasPermission('contents.view')
            && ($this->canManageAllContent($user) || $this->isAssignedTeacher($user, $content) || $user->hasRole(['student', 'reviewer', 'support']));
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('contents.create');
    }

    public function update(User $user, ContentLesson $content): bool
    {
        return $user->hasPermission('contents.update')
            && ($this->canManageAllContent($user) || $this->isAssignedTeacher($user, $content));
    }

    public function delete(User $user, ContentLesson $content): bool
    {
        return $user->hasPermission('contents.delete')
            && ($this->canManageAllContent($user) || $this->isAssignedTeacher($user, $content));
    }

    public function publish(User $user, ContentLesson $content): bool
    {
        return $user->hasPermission('contents.publish')
            && ($this->canManageAllContent($user) || $this->isAssignedTeacher($user, $content));
    }

    private function canManageAllContent(User $user): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'course-manager']);
    }

    private function isAssignedTeacher(User $user, ContentLesson $content): bool
    {
        return $content->course?->teachers()
            ->where('teachers.email', $user->email)
            ->exists() ?? false;
    }
}
