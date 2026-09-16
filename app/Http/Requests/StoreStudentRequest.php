<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'first_name_latin' => 'required|string|max:100',
            'last_name_latin' => 'nullable|string|max:100',
            'gender' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150|unique:students,email',
            'address' => 'nullable|string',
            'status' => 'nullable|string|max:30',
        ];
    }
}
