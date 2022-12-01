<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $requestData): User
    {
        $user = User::create([
            'name'  =>  $requestData['name'],
            'email' =>  $requestData['email'],
            'password' => Hash::make($requestData['password'])
        ]);

        return $user;
    }

    public function login(array $requestData): array
    {
        $user = User::where('email', $requestData['email'])
        ->first();

        if (!$user || !Hash::check($requestData['password'], $user->password)) throw new Exception('Incorrect email or password.');

        return [
            'user' => $user,
            'token' => $user->createToken('Token Name')->accessToken,
        ];
    }

    public function logOut(): bool
    {
        return auth()->user()->token()->delete();
    }
}