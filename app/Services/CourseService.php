<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    public function getAll(): Collection
    {
        return Course::with(['category', 'teachers', 'lessons'])->latest('course_id')->get();
    }

    public function create(array $data): Course
    {
        return Course::create([
            'course_category_id' => $data['course_category_id'],
            'course_code' => $this->generateCode(),
            'course_name' => $data['course_name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(Course $course, array $data): bool
    {
        return $course->update([
            'course_category_id' => $data['course_category_id'],
            'course_name' => $data['course_name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function delete(Course $course): bool
    {
        return $course->delete();
    }

    public function generateCode(): string
    {
        $nextId = (int) Course::max('course_id') + 1;

        do {
            $code = 'CRS-' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
            $nextId++;
        } while (Course::where('course_code', $code)->exists());

        return $code;
    }
}
