<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseCategoryRequest;
use App\Http\Requests\UpdateCourseCategoryRequest;
use App\Http\Resources\CourseCategoryResource;
use App\Models\CourseCategory;
use App\Services\CourseCategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CourseCategoryApiController extends Controller
{
    public function __construct(private readonly CourseCategoryService $courseCategoryService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return CourseCategoryResource::collection($this->courseCategoryService->getAll());
    }

    public function store(StoreCourseCategoryRequest $request): JsonResponse
    {
        $courseCategory = $this->courseCategoryService->create($request->validated());

        return (new CourseCategoryResource($courseCategory))
            ->response()
            ->setStatusCode(201);
    }

    public function show(CourseCategory $courseCategory): CourseCategoryResource
    {
        return new CourseCategoryResource($courseCategory->loadCount('courses'));
    }

    public function update(UpdateCourseCategoryRequest $request, CourseCategory $courseCategory): CourseCategoryResource
    {
        $this->courseCategoryService->update($courseCategory, $request->validated());

        return new CourseCategoryResource($courseCategory->fresh()->loadCount('courses'));
    }

    public function destroy(CourseCategory $courseCategory): JsonResponse
    {
        try {
            $this->courseCategoryService->delete($courseCategory);
        } catch (QueryException) {
            return response()->json([
                'message' => 'Course category cannot be deleted because it is used by courses.',
            ], 409);
        }

        return response()->json([
            'message' => 'Course category deleted successfully.',
        ]);
    }
}
