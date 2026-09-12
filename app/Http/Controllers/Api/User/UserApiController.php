<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserApiController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->getAll());
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());
        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $this->userService->update($user, $request->validated());
        return new UserResource($user->fresh());
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            $this->userService->delete($user);
        } catch (QueryException) {
            return response()->json([
                'message' => 'User cannot be deleted because they are used by other records.',
            ], 409);
        }

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }
}
