<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StudentApiController extends Controller
{
    public function __construct(private readonly StudentService $studentService) {}

    public function index(): AnonymousResourceCollection
    {
        return StudentResource::collection($this->studentService->getAll());
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        $student = $this->studentService->create($request->validated());
        return (new StudentResource($student))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Student $student): StudentResource
    {
        return new StudentResource($student);
    }

    public function update(UpdateStudentRequest $request, Student $student): StudentResource
    {
        $this->studentService->update($student, $request->validated());
        return new StudentResource($student->fresh());
    }

    public function destroy(Student $student): JsonResponse
    {
        try {
            $this->studentService->delete($student);
        } catch (QueryException) {
            return response()->json([
                'message' => 'Student cannot be deleted because they are used by other records.',
            ], 409);
        }

        return response()->json([
            'message' => 'Student deleted successfully.',
        ]);
    }
}
