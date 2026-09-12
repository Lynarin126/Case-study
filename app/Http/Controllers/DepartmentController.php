<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\Faculty;
use App\Services\DepartmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function __construct(private readonly DepartmentService $departmentService)
    {
    }

    public function index(Request $request): View
    {
        $departments = $this->departmentService->getAll();

        return view('departments.index', compact('departments'));
    }

    public function create(): View
    {
        $departmentCode = $this->departmentService->generateCode();
        $faculties = Faculty::orderBy('faculty_name')->get();

        return view('departments.create', compact('departmentCode', 'faculties'));
    }

    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $this->departmentService->create($request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', 'បានបង្កើតដេប៉ាតឺម៉ង់ដោយជោគជ័យ។');
    }

    public function edit(Department $department): View
    {
        $faculties = Faculty::orderBy('faculty_name')->get();

        return view('departments.edit', compact('department', 'faculties'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $this->departmentService->update($department, $request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', 'បានកែប្រែដេប៉ាតឺម៉ង់ដោយជោគជ័យ។');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $this->departmentService->delete($department);

        return redirect()
            ->route('departments.index')
            ->with('success', 'បានលុបដេប៉ាតឺម៉ង់ដោយជោគជ័យ។');
    }
}
