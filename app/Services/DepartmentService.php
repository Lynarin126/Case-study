<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentService
{
    public function getAll(): Collection
    {
        return Department::with('faculty')->latest('department_id')->get();
    }

    public function create(array $data): Department
    {
        return Department::create([
            'faculty_id' => $data['faculty_id'] ?? null,
            'department_code' => $this->generateCode(),
            'department_name' => $data['department_name'],
            'deans' => $data['deans'] ?? null,
        ]);
    }

    public function update(Department $department, array $data): bool
    {
        return $department->update([
            'faculty_id' => $data['faculty_id'] ?? null,
            'department_name' => $data['department_name'],
            'deans' => $data['deans'] ?? null,
        ]);
    }

    public function delete(Department $department): bool
    {
        return $department->delete();
    }

    public function generateCode(): string
    {
        $nextId = (int) Department::max('department_id') + 1;

        do {
            $code = 'DEP-' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
            $nextId++;
        } while (Department::where('department_code', $code)->exists());

        return $code;
    }
}
