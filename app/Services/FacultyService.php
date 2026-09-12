<?php

namespace App\Services;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Collection;

class FacultyService
{
    public function getAll(): Collection
    {
        return Faculty::latest('faculty_id')->get();
    }

    public function create(array $data): Faculty
    {
        return Faculty::create([
            'faculty_code' => $this->generateCode(),
            'faculty_name' => $data['faculty_name'],
        ]);
    }

    public function update(Faculty $faculty, array $data): bool
    {
        return $faculty->update([
            'faculty_name' => $data['faculty_name'],
        ]);
    }

    public function delete(Faculty $faculty): bool
    {
        return $faculty->delete();
    }

    public function generateCode(): string
    {
        $nextId = (int) Faculty::max('faculty_id') + 1;

        do {
            $code = 'FAC-' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
            $nextId++;
        } while (Faculty::where('faculty_code', $code)->exists());

        return $code;
    }
}
