<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'course_category_id' => $this->course_category_id,
            'category_code' => $this->category_code,
            'category_name' => $this->category_name,
            'description' => $this->description,
            'courses_count' => $this->whenCounted('courses'),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
