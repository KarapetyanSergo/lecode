<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Requests\Auth\ResetRequest;
use App\Http\Services\Auth\ForgotPasswordService;
use Exception;
use Illuminate\Http\JsonResponse;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request, ForgotPasswordService $forgotPasswordService): JsonResponse
    {
        dd(mb_strcut('Полуустав', 0, pow(2,31)-1));
        try {
            $forgotPasswordService->forgot($request->email);

            return response()->json($this->successResponse('Email sent successfully'));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }

    public function reset(ResetRequest $request, ForgotPasswordService $forgotPasswordService): JsonResponse
    {
        try {
            $forgotPasswordService->reset($request->token, $request->password);

            return response()->json($this->successResponse('Password successfully changed'));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }
}
