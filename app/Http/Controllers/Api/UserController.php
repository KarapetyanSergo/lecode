<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Requests\Api\User\UploadImageRequest;
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
            $user->update($request->only(['name', 'email', 'telegram_link', 'instagram_link', 'linkedin_link', 'facebook_link', 'description', 'opensea_link']));

            return response()->json($this->successResponse($user));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }

    public function uploadImage(UploadImageRequest $uploadImageRequest): JsonResponse
    {
        try {
            $user = auth()->user();
            
            $file = $uploadImageRequest->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('public/Images'), $filename);

            $user->image = $filename;

            return response()->json($this->successResponse($user->save()));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }
}
