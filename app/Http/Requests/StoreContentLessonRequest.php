<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContentLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,course_id'],
            'course_module_id' => ['required', 'integer', 'exists:course_modules,course_module_id'],
            'content_type' => ['required', Rule::in(['lesson', 'page', 'video', 'file', 'url', 'assignment', 'quiz'])],
            'title' => ['required', 'string', 'min:3', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', 'unique:content_lessons,slug'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'body' => ['required', 'string', 'min:10'],
            'thumbnail' => ['nullable', 'image', 'max:4096'],
            'position' => ['required', 'integer', 'min:1'],
            'completion_type' => ['required', Rule::in(['manual', 'video_watched', 'quiz_passed', 'assignment_submitted', 'any_requirement', 'all_requirements'])],
            'minimum_watch_percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
            'video_source' => ['nullable', Rule::in(['upload', 'youtube', 'vimeo', 'external'])],
            'video_url' => [
                'nullable',
                'url',
                Rule::requiredIf(fn () => $this->input('content_type') === 'video' && in_array($this->input('video_source'), ['youtube', 'vimeo', 'external'], true)),
            ],
            'video_upload' => [
                'nullable',
                'file',
                'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm',
                'max:512000',
                Rule::requiredIf(fn () => $this->input('content_type') === 'video' && $this->input('video_source') === 'upload'),
            ],
            'video_duration' => ['nullable', 'integer', 'min:0'],
            'video_thumbnail' => ['nullable', 'image', 'max:4096'],
            'quiz.passing_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'quiz.attempts_allowed' => ['nullable', 'integer', 'min:1'],
            'quiz.time_limit' => ['nullable', 'integer', 'min:0'],
            'assignment.maximum_score' => ['nullable', 'numeric', 'min:0'],
            'assignment.due_date' => ['nullable', 'date'],
            'document.document_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', 'max:102400'],
            'attachments.*' => ['nullable', 'file', 'max:102400'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'publish_date' => ['nullable', 'date'],
            'publish_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (! $this->filled(['course_id', 'course_module_id'])) {
                return;
            }

            $belongsToCourse = \App\Models\CourseModule::where('course_module_id', $this->input('course_module_id'))
                ->where('course_id', $this->input('course_id'))
                ->exists();

            if (! $belongsToCourse) {
                $validator->errors()->add('course_module_id', 'The selected chapter does not belong to the selected course.');
            }
        });
    }
}
