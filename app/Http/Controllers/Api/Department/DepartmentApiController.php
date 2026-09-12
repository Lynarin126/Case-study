<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DepartmentApiController extends Controller
{
    public function __construct(private readonly DepartmentService $departmentService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return DepartmentResource::collection($this->departmentService->getAll());
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $department = $this->departmentService->create($request->validated());

        return (new DepartmentResource($department->load('faculty')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Department $department): DepartmentResource
    {
        return new DepartmentResource($department->load('faculty'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department): DepartmentResource
    {
        $this->departmentService->update($department, $request->validated());

        return new DepartmentResource($department->fresh()->load('faculty'));
    }

    public function destroy(Department $department): JsonResponse
    {
        try {
            $this->departmentService->delete($department);
        } catch (QueryException) {
            return response()->json([
                'message' => 'Department cannot be deleted because it is used by other records.',
            ], 409);
        }

        return response()->json([
            'message' => 'Department deleted successfully.',
        ]);
    }
}
