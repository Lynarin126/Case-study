<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseModule;
use Illuminate\Http\Request;

class CourseModuleController extends Controller
{
    public function index(Course $course)
    {
        // Eager load lessons for each module
        $modules = $course->courseModules()->with('lessons')->orderBy('module_number')->get();
        return view('course_modules.index', compact('course', 'modules'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'module_number' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $course->courseModules()->create($validated);

        return redirect()->back()->with('success', 'បានបង្កើតម៉ូឌុលថ្មីដោយជោគជ័យ។');
    }
}
