<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentLessonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->content_lesson_id,
            'content_lesson_id' => $this->content_lesson_id,
            'course_id' => $this->course_id,
            'course_module_id' => $this->course_module_id,
            'module_number' => $this->module_number,
            'moduleTitle' => $this->module_title ?: ('Module ' . $this->module_number),
            'module_title' => $this->module_title,
            'title' => $this->title,
            'slug' => $this->slug,
            'contentType' => $this->content_type,
            'content_type' => $this->content_type,
            'summary' => $this->summary,
            'body' => $this->body,
            'content' => $this->body,
            'videoUrl' => $this->video_url,
            'video_url' => $this->video_url,
            'duration' => $this->duration_minutes ? ($this->duration_minutes . 'm') : '30m',
            'duration_minutes' => $this->duration_minutes,
            'position' => $this->position,
            'isCompleted' => false,
            'isLocked' => false,
            'visibility' => $this->visibility,
            'is_published' => (bool) $this->is_published,
            'max_score' => $this->max_score,
            'passing_score' => $this->passing_score,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
