<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Requests\Api\User\UploadImageRequest;
use App\Http\Resources\UserResource;
use ErrorException;
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

    public function getNews(): JsonResponse
    {
        $news = auth()->user()->unreadNotifications;

        return response()->json($this->successResponse($news));
    }

    public function markNewsAsRead($newsId): JsonResponse
    {
        try {
            $notification = auth()->user()->unreadNotifications
            ->where('id', $newsId)
            ->first();

            if (!$notification) {
                throw new ErrorException('Unread news with id '.$newsId.' does not exists');
            };

            $notification->markAsRead();

            return response()->json($this->successResponse(true));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }
}
