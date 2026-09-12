<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->latest('enrollment_date')->get();
        $students = Student::all();
        $courses = Course::all();
        
        $enrolledStudentsMap = Enrollment::select('course_id', 'student_id')
            ->get()
            ->groupBy('course_id')
            ->map(function ($items) {
                return $items->pluck('student_id');
            });

        return view('enrollments.index', compact('enrollments', 'students', 'courses', 'enrolledStudentsMap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'enrollment_date' => 'required|date',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        Enrollment::create($validated);
        return redirect()->back()->with('success', 'ការចុះឈ្មោះត្រូវបានបង្កើតដោយជោគជ័យ។');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
