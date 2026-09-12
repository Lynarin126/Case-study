<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct(private readonly StudentService $studentService) {}

    public function index(Request $request): View
    {
        $students = $this->studentService->getAll();
        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        $studentCode = $this->studentService->generateCode();
        return view('students.create', compact('studentCode'));
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $this->studentService->create($request->validated());
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student): View
    {
        return view('students.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $this->studentService->update($student, $request->validated());
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $this->studentService->delete($student);
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
