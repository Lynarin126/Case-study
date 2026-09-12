<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseCategoryRequest;
use App\Http\Requests\UpdateCourseCategoryRequest;
use App\Models\CourseCategory;
use App\Services\CourseCategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseCategoryController extends Controller
{
    public function __construct(private readonly CourseCategoryService $courseCategoryService)
    {
    }

    public function index(Request $request): View
    {
        $courseCategories = $this->courseCategoryService->getAll();

        return view('course_categories.index', compact('courseCategories'));
    }

    public function create(): View
    {
        $categoryCode = $this->courseCategoryService->generateCode();

        return view('course_categories.create', compact('categoryCode'));
    }

    public function store(StoreCourseCategoryRequest $request): RedirectResponse
    {
        $this->courseCategoryService->create($request->validated());

        return redirect()
            ->route('course-categories.index')
            ->with('success', 'បានបង្កើតប្រភេទវគ្គសិក្សាដោយជោគជ័យ។');
    }

    public function edit(CourseCategory $courseCategory): View
    {
        return view('course_categories.edit', compact('courseCategory'));
    }

    public function update(UpdateCourseCategoryRequest $request, CourseCategory $courseCategory): RedirectResponse
    {
        $this->courseCategoryService->update($courseCategory, $request->validated());

        return redirect()
            ->route('course-categories.index')
            ->with('success', 'បានកែប្រែប្រភេទវគ្គសិក្សាដោយជោគជ័យ។');
    }

    public function destroy(CourseCategory $courseCategory): RedirectResponse
    {
        try {
            $this->courseCategoryService->delete($courseCategory);
        } catch (QueryException) {
            return redirect()
                ->route('course-categories.index')
                ->with('error', 'មិនអាចលុបបានទេ ព្រោះមានវគ្គសិក្សាកំពុងប្រើប្រភេទនេះ។');
        }

        return redirect()
            ->route('course-categories.index')
            ->with('success', 'បានលុបប្រភេទវគ្គសិក្សាដោយជោគជ័យ។');
    }
}
