<?php

namespace App\Services;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Collection;

class AcademicYearService
{
    public function getAll(): Collection
    {
        return AcademicYear::latest('academic_year_id')->get();
    }

    public function create(array $data): AcademicYear
    {
        return AcademicYear::create([
            'year_name' => $data['year_name'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_active' => $data['is_active'] ?? false,
        ]);
    }

    public function update(AcademicYear $academicYear, array $data): bool
    {
        return $academicYear->update([
            'year_name' => $data['year_name'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_active' => $data['is_active'] ?? false,
        ]);
    }

    public function delete(AcademicYear $academicYear): bool
    {
        return $academicYear->delete();
    }
}
