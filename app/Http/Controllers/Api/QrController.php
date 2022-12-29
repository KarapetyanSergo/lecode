<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use Exception;
use Illuminate\Http\JsonResponse;

class QrController extends Controller
{
    public function attachUser(QrCode $qrCode): JsonResponse
    {
        $qrCode->user_id = auth()->user()->id;
        $qrCode->save();

        return response()->json($this->successResponse($qrCode));
    }

    public function createQrCode(string $token): JsonResponse
    {
        try {
            $qrCode = QrCode::create([
                'token' => $token
            ]);

            return response()->json($this->successResponse($qrCode));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }
}
