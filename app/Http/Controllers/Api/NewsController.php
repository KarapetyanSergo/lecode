<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ErrorException;
use Exception;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    public function getNews(): JsonResponse
    {
        $news = auth()->user()->unreadNotifications;

        return response()->json($this->successResponse($news));
    }

    public function markNewsAsRead(string $newsId): JsonResponse
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
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }
}
