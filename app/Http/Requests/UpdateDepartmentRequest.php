<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'faculty_id' => ['nullable', 'integer', 'exists:faculties,faculty_id'],
            'department_name' => ['required', 'string', 'max:150'],
            'deans' => ['nullable', 'string', 'max:255'],
        ];
    }
}
