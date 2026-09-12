<?php

namespace App\Http\Controllers\Api\Faculty;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use App\Services\FacultyService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FacultyApiController extends Controller
{
    public function __construct(private readonly FacultyService $facultyService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return FacultyResource::collection($this->facultyService->getAll());
    }

    public function store(StoreFacultyRequest $request): JsonResponse
    {
        $faculty = $this->facultyService->create($request->validated());

        return (new FacultyResource($faculty))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Faculty $faculty): FacultyResource
    {
        return new FacultyResource($faculty);
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty): FacultyResource
    {
        $this->facultyService->update($faculty, $request->validated());

        return new FacultyResource($faculty->fresh());
    }

    public function destroy(Faculty $faculty): JsonResponse
    {
        try {
            $this->facultyService->delete($faculty);
        } catch (QueryException) {
            return response()->json([
                'message' => 'Faculty cannot be deleted because it is used by other records.',
            ], 409);
        }

        return response()->json([
            'message' => 'Faculty deleted successfully.',
        ]);
    }
}
