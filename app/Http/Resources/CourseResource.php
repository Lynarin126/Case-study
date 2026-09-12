<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function jsonOptions(): int
    {
        return JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->course_id,
            'course_id' => $this->course_id,
            'course_category_id' => $this->course_category_id,
            'course_code' => $this->course_code,
            'course_name' => $this->course_name,
            'title' => $this->course_name,
            'description' => $this->description,
            'visibility' => $this->visibility,
            'category' => new CourseCategoryResource($this->whenLoaded('category')),
            'teacher' => $this->relationLoaded('teachers') && $this->teachers->isNotEmpty()
                ? trim(($this->teachers->first()->first_name ?? '') . ' ' . ($this->teachers->first()->last_name ?? ''))
                : 'Sovann Sok',
            'lessonsCount' => $this->relationLoaded('lessons') ? $this->lessons->count() : $this->lessons()->count(),
            'duration' => ($this->relationLoaded('lessons') ? $this->lessons->sum('duration_minutes') : $this->lessons()->sum('duration_minutes')) * 60,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
