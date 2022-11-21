<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $signUpRequest, AuthService $authService): JsonResponse
    {
        $validatedData = $signUpRequest->validated();

        $register = $authService->register($validatedData);

        return response()->json($this->successResponse($register));
    }
}
