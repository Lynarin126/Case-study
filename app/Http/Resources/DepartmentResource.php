<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'department_id' => $this->department_id,
            'faculty_id' => $this->faculty_id,
            'department_code' => $this->department_code,
            'department_name' => $this->department_name,
            'deans' => $this->deans,
            'faculty' => new FacultyResource($this->whenLoaded('faculty')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
