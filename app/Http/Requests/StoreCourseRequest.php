<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_category_id' => ['required', 'integer', 'exists:course_categories,course_category_id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,department_id'],
            'course_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ];
    }
}
