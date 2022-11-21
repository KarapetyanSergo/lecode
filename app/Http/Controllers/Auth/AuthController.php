<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $signUpRequest, AuthService $authService): JsonResponse
    {
        $validatedData = $signUpRequest->validated();
        $register = $authService->register($validatedData);
    
        return response()->json($this->successResponse($register));
    }

    public function signIn(SignInRequest $signInRequest, AuthService $authService): JsonResponse
    {
        try {
            $validatedData = $signInRequest->validated();
            $response = $authService->login($validatedData);

            return response()->json($this->successResponse($response));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()));
        }
    }

    public function signOut(AuthService $authService): JsonResponse
    {
        return response()->json($this->successResponse($authService->logOut()));
    }
}
