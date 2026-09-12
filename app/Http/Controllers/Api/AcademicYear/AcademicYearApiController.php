<?php

namespace App\Http\Controllers\Api\AcademicYear;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcademicYearRequest;
use App\Http\Requests\UpdateAcademicYearRequest;
use App\Http\Resources\AcademicYearResource;
use App\Models\AcademicYear;
use App\Services\AcademicYearService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AcademicYearApiController extends Controller
{
    public function __construct(private readonly AcademicYearService $academicYearService) {}

    public function index(): AnonymousResourceCollection
    {
        return AcademicYearResource::collection($this->academicYearService->getAll());
    }

    public function store(StoreAcademicYearRequest $request): JsonResponse
    {
        $academicYear = $this->academicYearService->create($request->validated());
        return (new AcademicYearResource($academicYear))
            ->response()
            ->setStatusCode(201);
    }

    public function show(AcademicYear $academicYear): AcademicYearResource
    {
        return new AcademicYearResource($academicYear);
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear): AcademicYearResource
    {
        $this->academicYearService->update($academicYear, $request->validated());
        return new AcademicYearResource($academicYear->fresh());
    }

    public function destroy(AcademicYear $academicYear): JsonResponse
    {
        try {
            $this->academicYearService->delete($academicYear);
        } catch (QueryException) {
            return response()->json([
                'message' => 'Academic Year cannot be deleted because it is used by other records.',
            ], 409);
        }

        return response()->json([
            'message' => 'Academic Year deleted successfully.',
        ]);
    }
}
