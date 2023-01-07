<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use App\Models\QrScanHistory;
use Illuminate\Http\JsonResponse;

class QrController extends Controller
{
    public function attachUser(QrCode $qrCode): JsonResponse
    {
        $qrCode->user_id = auth()->user()->id;
        $qrCode->save();

        return response()->json($this->successResponse($qrCode));
    }

    public function getScansHistories(QrCode $qrCode): JsonResponse
    {
        return response()->json($this->successResponse(QrScanHistory::where('qr_id', $qrCode->id)->with('scanned_by')->get()));
    }
}
