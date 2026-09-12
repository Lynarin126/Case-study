<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\Faculty;
use App\Services\FacultyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function __construct(private readonly FacultyService $facultyService)
    {
    }

    public function index(Request $request): View
    {
        $faculties = $this->facultyService->getAll();

        return view('faculties.index', compact('faculties'));
    }

    public function create(): View
    {
        $facultyCode = $this->facultyService->generateCode();

        return view('faculties.create', compact('facultyCode'));
    }

    public function store(StoreFacultyRequest $request): RedirectResponse
    {
        $this->facultyService->create($request->validated());

        return redirect()
            ->route('faculties.index')
            ->with('success', 'បានបង្កើតមហាវិទ្យាល័យដោយជោគជ័យ។');
    }

    public function edit(Faculty $faculty): View
    {
        return view('faculties.edit', compact('faculty'));
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty): RedirectResponse
    {
        $this->facultyService->update($faculty, $request->validated());

        return redirect()
            ->route('faculties.index')
            ->with('success', 'បានកែប្រែមហាវិទ្យាល័យដោយជោគជ័យ។');
    }

    public function destroy(Faculty $faculty): RedirectResponse
    {
        $this->facultyService->delete($faculty);

        return redirect()
            ->route('faculties.index')
            ->with('success', 'បានលុបមហាវិទ្យាល័យដោយជោគជ័យ។');
    }
}
