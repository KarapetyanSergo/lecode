<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $requestData): ?User
    {
        $user = User::create([
            'name'  =>  $requestData['name'],
            'email' =>  $requestData['email'],
            'password' => Hash::make($requestData['password'])
        ]);

        return $user;
    }
}