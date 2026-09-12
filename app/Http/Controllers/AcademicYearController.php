<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcademicYearRequest;
use App\Http\Requests\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use App\Services\AcademicYearService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    public function __construct(private readonly AcademicYearService $academicYearService) {}

    public function index(Request $request): View
    {
        $academicYears = $this->academicYearService->getAll();
        return view('academic_years.index', compact('academicYears'));
    }

    public function create(): View
    {
        return view('academic_years.create');
    }

    public function store(StoreAcademicYearRequest $request): RedirectResponse
    {
        $this->academicYearService->create($request->validated());
        return redirect()->route('academic-years.index')->with('success', 'Academic Year created successfully.');
    }

    public function edit(AcademicYear $academicYear): View
    {
        return view('academic_years.edit', compact('academicYear'));
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear): RedirectResponse
    {
        $this->academicYearService->update($academicYear, $request->validated());
        return redirect()->route('academic-years.index')->with('success', 'Academic Year updated successfully.');
    }

    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        $this->academicYearService->delete($academicYear);
        return redirect()->route('academic-years.index')->with('success', 'Academic Year deleted successfully.');
    }
}
