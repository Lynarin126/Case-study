<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function __construct(private readonly TeacherService $teacherService) {}

    public function index(Request $request): View
    {
        $teachers = $this->teacherService->getAll();
        return view('teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        $teacherCode = $this->teacherService->generateCode();
        return view('teachers.create', compact('teacherCode'));
    }

    public function store(StoreTeacherRequest $request): RedirectResponse
    {
        $this->teacherService->create($request->validated());
        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher): View
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher): RedirectResponse
    {
        $this->teacherService->update($teacher, $request->validated());
        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $this->teacherService->delete($teacher);
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
