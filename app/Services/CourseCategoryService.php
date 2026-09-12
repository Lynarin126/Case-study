<?php

namespace App\Services;

use App\Models\CourseCategory;
use Illuminate\Database\Eloquent\Collection;

class CourseCategoryService
{
    public function getAll(): Collection
    {
        return CourseCategory::withCount('courses')->latest('course_category_id')->get();
    }

    public function create(array $data): CourseCategory
    {
        return CourseCategory::create([
            'category_code' => $this->generateCode(),
            'category_name' => $data['category_name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(CourseCategory $courseCategory, array $data): bool
    {
        return $courseCategory->update([
            'category_name' => $data['category_name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    public function delete(CourseCategory $courseCategory): bool
    {
        return $courseCategory->delete();
    }

    public function generateCode(): string
    {
        $nextId = (int) CourseCategory::max('course_category_id') + 1;

        do {
            $code = 'CAT-' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
            $nextId++;
        } while (CourseCategory::where('category_code', $code)->exists());

        return $code;
    }
}
