<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

class TeacherService
{
    public function getAll(): Collection
    {
        return Teacher::latest('teacher_id')->get();
    }

    public function create(array $data): Teacher
    {
        return Teacher::create([
            'teacher_code' => $this->generateCode(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'gender' => $data['gender'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'hire_date' => $data['hire_date'] ?? null,
            'status' => $data['status'] ?? 'active',
            'address' => $data['address'] ?? null,
        ]);
    }

    public function update(Teacher $teacher, array $data): bool
    {
        return $teacher->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'gender' => $data['gender'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'hire_date' => $data['hire_date'] ?? null,
            'status' => $data['status'] ?? 'active',
            'address' => $data['address'] ?? null,
        ]);
    }

    public function delete(Teacher $teacher): bool
    {
        return $teacher->delete();
    }

    public function generateCode(): string
    {
        $nextId = (int) Teacher::max('teacher_id') + 1;

        do {
            $code = 'TCH-' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
            $nextId++;
        } while (Teacher::where('teacher_code', $code)->exists());

        return $code;
    }
}
