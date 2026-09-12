<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TeacherApiController extends Controller
{
    public function __construct(private readonly TeacherService $teacherService) {}

    public function index(): AnonymousResourceCollection
    {
        return TeacherResource::collection($this->teacherService->getAll());
    }

    public function store(StoreTeacherRequest $request): JsonResponse
    {
        $teacher = $this->teacherService->create($request->validated());
        return (new TeacherResource($teacher))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Teacher $teacher): TeacherResource
    {
        return new TeacherResource($teacher);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher): TeacherResource
    {
        $this->teacherService->update($teacher, $request->validated());
        return new TeacherResource($teacher->fresh());
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        try {
            $this->teacherService->delete($teacher);
        } catch (QueryException) {
            return response()->json([
                'message' => 'Teacher cannot be deleted because they are used by other records.',
            ], 409);
        }

        return response()->json([
            'message' => 'Teacher deleted successfully.',
        ]);
    }
}
