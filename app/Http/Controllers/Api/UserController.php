<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function getUser(): JsonResponse
    {
        return response()->json($this->successResponse(new UserResource(auth()->user())));
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $user->update($request->only(['name', 'email']));

            return response()->json($this->successResponse($user));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }
}
