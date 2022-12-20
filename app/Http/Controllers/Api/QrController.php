<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use Illuminate\Http\JsonResponse;

class QrController extends Controller
{
    public function attachUser(string $token): JsonResponse
    {
        if (!$qrCode = QrCode::where('token', $token)->get()->first()) {
            return response()->json($this->errorResponse('QR doesn\'t exist'));
        }

        $user = auth()->user();
        $qrCode->user_id = $user->id;
        $qrCode->save();

        return response()->json($this->successResponse($qrCode));
    }
}
