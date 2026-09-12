<?php

namespace App\Helpers;

class PermissionHelper
{
    private static array $modules = [
        'Dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
        'Users' => 'អ្នកប្រើប្រាស់',
        'Students' => 'និស្សិត',
        'Instructors' => 'គ្រូបង្រៀន',
        'Courses' => 'វគ្គសិក្សា',
        'Course Categories' => 'ប្រភេទវគ្គសិក្សា',
        'Chapters' => 'ជំពូកសិក្សា',
        'Content' => 'មាតិកាមេរៀន',
        'Videos' => 'វីដេអូ',
        'Documents' => 'ឯកសារ',
        'Quizzes' => 'កម្រងសំណួរ',
        'Questions' => 'សំណួរ',
        'Assignments' => 'កិច្ចការ',
        'Enrollments' => 'ការចុះឈ្មោះ',
        'Student Progress' => 'វឌ្ឍនភាពសិក្សា',
        'Quiz Results' => 'លទ្ធផលតេស្ត',
        'Grades' => 'ពិន្ទុ',
        'Certificates' => 'វិញ្ញាបនបត្រ',
        'Reports' => 'របាយការណ៍',
        'Roles' => 'តួនាទី',
        'Permissions' => 'សិទ្ធិអនុញ្ញាត',
        'Settings' => 'ការកំណត់',
    ];

    private static array $actions = [
        'view' => 'មើល',
        'create' => 'បង្កើត',
        'update' => 'កែប្រែ',
        'delete' => 'លុប',
        'publish' => 'បោះពុម្ពផ្សាយ',
        'export' => 'នាំចេញ',
        'archive' => 'ប័ណ្ណសារ',
        'reorder' => 'រៀបលំដាប់',
        'download' => 'ទាញយក',
        'grade' => 'ដាក់ពិន្ទុ',
        'view_own' => 'មើលផ្ទាល់ខ្លួន',
        'verify' => 'ផ្ទៀងផ្ទាត់',
        'assign' => 'ចាត់តាំង',
        'restore' => 'ស្តារឡើងវិញ',
    ];

    private static array $roles = [
        'super-admin' => 'អ្នកគ្រប់គ្រងជាន់ខ្ពស់ (Super Admin)',
        'admin' => 'អ្នកគ្រប់គ្រង (Admin)',
        'instructor' => 'គ្រូបង្រៀន (Instructor)',
        'course-manager' => 'អ្នកគ្រប់គ្រងវគ្គសិក្សា (Course Manager)',
        'student' => 'និស្សិត (Student)',
        'reviewer' => 'អ្នកត្រួតពិនិត្យ (Reviewer)',
        'support' => 'ផ្នែកគាំទ្រ (Support)',
    ];

    public static function module(string $name): string
    {
        return self::$modules[$name] ?? $name;
    }

    public static function action(string $name): string
    {
        return self::$actions[$name] ?? $name;
    }

    public static function roleName(string $slug, ?string $fallback = null): string
    {
        return self::$roles[$slug] ?? $fallback ?? $slug;
    }
}
