<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseModule;
use App\Models\ContentLesson;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the LMS administrator/instructor dashboard with real metrics.
     */
    public function index()
    {
        $totalCourses = Course::count();
        $activeCourses = Course::where(function ($q) {
            $q->where('visibility', 'public')
              ->orWhereNull('visibility')
              ->orWhere('visibility', 'published');
        })->count();

        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalEnrollments = Enrollment::count();
        $totalLessons = ContentLesson::count();
        $totalModules = CourseModule::count();
        $totalCategories = CourseCategory::count();
        $totalDepartments = Department::count();
        $totalFaculties = Faculty::count();

        // Calculate lesson / enrollment completion rate
        $completedEnrollments = Enrollment::where('status', 'completed')->count();
        $completionRate = $totalEnrollments > 0 
            ? round(($completedEnrollments / $totalEnrollments) * 100) 
            : 0;

        // Recent 6 enrollments
        $recentEnrollments = Enrollment::with(['student', 'course'])
            ->latest('enrollment_date')
            ->latest('created_at')
            ->take(6)
            ->get();

        // Top 5 popular courses by enrollment count
        $popularCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        $maxEnrollments = $popularCourses->max('enrollments_count') ?: 1;

        // Recent 5 courses
        $recentCourses = Course::with(['category'])
            ->withCount(['enrollments', 'courseModules'])
            ->latest()
            ->take(5)
            ->get();

        // Recent 5 students
        $recentStudents = Student::latest()->take(5)->get();

        return view('dashboard.dashboard', compact(
            'totalCourses',
            'activeCourses',
            'totalStudents',
            'totalTeachers',
            'totalEnrollments',
            'totalLessons',
            'totalModules',
            'totalCategories',
            'totalDepartments',
            'totalFaculties',
            'completionRate',
            'recentEnrollments',
            'popularCourses',
            'maxEnrollments',
            'recentCourses',
            'recentStudents'
        ));
    }
}
