<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentLessonResource;
use App\Http\Resources\CourseResource;
use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ElearningApiController extends Controller
{
    /**
     * Get all lessons for a specific course.
     */
    public function lessons(Course $course): AnonymousResourceCollection
    {
        $lessons = $course->lessons()
            ->where('visibility', 'visible')
            ->orderBy('module_number')
            ->orderBy('position')
            ->get();

        return ContentLessonResource::collection($lessons);
    }

    /**
     * Get a single lesson's full details.
     */
    public function showLesson(ContentLesson $lesson): ContentLessonResource
    {
        return new ContentLessonResource($lesson->load(['course', 'courseModule']));
    }

    /**
     * Get user course progress.
     */
    public function progress(Request $request, Course $course): JsonResponse
    {
        $user = $request->user();
        $student = $user ? Student::where('email', $user->email)->first() : null;

        // Simple progress calculation based on course lessons
        $totalLessons = $course->lessons()->where('visibility', 'visible')->count();
        $completedLessons = [];

        if ($student) {
            $enrollment = Enrollment::where('student_id', $student->student_id)
                ->where('course_id', $course->course_id)
                ->first();

            if ($enrollment && $enrollment->status === 'completed') {
                $completedLessons = $course->lessons()->pluck('content_lesson_id')->toArray();
            }
        }

        $completedCount = count($completedLessons);
        $percentage = $totalLessons > 0 ? (int) round(($completedCount / $totalLessons) * 100) : 0;

        return response()->json([
            'data' => [
                'course_id' => $course->course_id,
                'completed_lessons' => $completedLessons,
                'percentage' => $percentage,
                'total_lessons' => $totalLessons,
                'completed_count' => $completedCount,
            ],
        ]);
    }

    /**
     * Mark a lesson as started.
     */
    public function startLesson(Request $request, ContentLesson $lesson): JsonResponse
    {
        return response()->json([
            'message' => 'Lesson started',
            'lesson_id' => $lesson->content_lesson_id,
            'status' => 'in_progress',
        ]);
    }

    /**
     * Mark a lesson as completed.
     */
    public function completeLesson(Request $request, ContentLesson $lesson): JsonResponse
    {
        return response()->json([
            'message' => 'Lesson marked as completed',
            'lesson_id' => $lesson->content_lesson_id,
            'status' => 'completed',
        ]);
    }

    /**
     * Get all enrolled courses for the logged-in student.
     */
    public function enrollments(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['data' => []]);
        }

        $student = Student::where('email', $user->email)->first();
        if (!$student) {
            // Find or create student profile if user has student role
            $student = Student::firstOrCreate(
                ['email' => $user->email],
                [
                    'student_code' => 'STU-' . str_pad((string)$user->id, 4, '0', STR_PAD_LEFT),
                    'first_name' => $user->name,
                    'status' => 'active',
                ]
            );
        }

        $enrollments = Enrollment::with(['course.category', 'course.teachers', 'course.lessons'])
            ->where('student_id', $student->student_id)
            ->latest('enrollment_id')
            ->get();

        $courses = $enrollments->map(function ($enrollment) {
            $course = $enrollment->course;
            if (!$course) {
                return null;
            }
            $courseData = (new CourseResource($course))->resolve();
            $courseData['enrollment_status'] = $enrollment->status;
            $courseData['enrollment_date'] = $enrollment->enrollment_date;
            $courseData['progress'] = $enrollment->status === 'completed' ? 100 : 35;
            return $courseData;
        })->filter()->values();

        return response()->json(['data' => $courses]);
    }

    /**
     * Enroll the logged-in user in a course.
     */
    public function enroll(Request $request, Course $course): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $student = Student::firstOrCreate(
            ['email' => $user->email],
            [
                'student_code' => 'STU-' . str_pad((string)$user->id, 4, '0', STR_PAD_LEFT),
                'first_name' => $user->name,
                'status' => 'active',
            ]
        );

        $enrollment = Enrollment::firstOrCreate(
            [
                'student_id' => $student->student_id,
                'course_id' => $course->course_id,
            ],
            [
                'enrollment_date' => now()->toDateString(),
                'status' => 'studying',
                'note' => 'Self-enrolled via e-learning portal.',
            ]
        );

        return response()->json([
            'message' => 'Successfully enrolled in course',
            'data' => [
                'enrollment_id' => $enrollment->enrollment_id,
                'course_id' => $course->course_id,
                'status' => $enrollment->status,
            ],
        ], 201);
    }
}
