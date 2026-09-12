<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentService
{
    public function getAll(): Collection
    {
        return Student::latest('student_id')->get();
    }

    public function create(array $data): Student
    {
        return Student::create([
            'student_code' => $this->generateCode(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
    }

    public function update(Student $student, array $data): bool
    {
        return $student->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
    }

    public function delete(Student $student): bool
    {
        return $student->delete();
    }

    public function generateCode(): string
    {
        $nextId = (int) Student::max('student_id') + 1;

        do {
            $code = 'STU-' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
            $nextId++;
        } while (Student::where('student_code', $code)->exists());

        return $code;
    }
}
