<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'gender' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150|unique:teachers,email',
            'specialization' => 'nullable|string|max:150',
            'hire_date' => 'nullable|date',
            'status' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ];
    }
}
