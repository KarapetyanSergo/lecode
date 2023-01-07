<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Requests\Api\User\UploadImageRequest;
use App\Http\Resources\UserResource;
use App\Models\QrCode;
use App\Models\QrScanHistory;
use App\Notifications\UserNewsNotification;
use ErrorException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

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

    public function uploadLogo(UploadImageRequest $uploadImageRequest): JsonResponse
    {
        try {
            $user = auth()->user();
            
            $file = $uploadImageRequest->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('public/Images/Logos'), $filename);

            $user->logo = $filename;

            return response()->json($this->successResponse($user->save()));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }

    public function uploadBackgroundImage(UploadImageRequest $uploadImageRequest): JsonResponse
    {
        try {
            $user = auth()->user();
            
            $file = $uploadImageRequest->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('public/Images/BackgroundImages'), $filename);

            $user->background_image = $filename;

            return response()->json($this->successResponse($user->save()));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }

    public function getUserByQrToken(QrCode $qrCode): JsonResponse
    {
        if (!$qrCode->user_id) {
            return response()->json($this->errorResponse('User Not Found'), 404);
        }

        $user = $qrCode->user;
        $authUser = auth('api')->user();

        if ($authUser) {
            QrScanHistory::create([
                'qr_id' => $qrCode->id,
                'scanned_by' => $authUser->id
            ]);
            $message = $authUser->name.' scanned your qr-code';
        } else {
            $message = 'An unknown user has scanned your qr-code';
        }

        Notification::send($user, new UserNewsNotification('qr code scanned', $message));
        
        return response()->json($this->successResponse(new UserResource($user)));
    }
}
