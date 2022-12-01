<?php

namespace App\Http\Services\Auth;

use App\Mail\ForgotPasswordEmail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordService
{
    public function forgot(string $email): void
    {
        $token = Str::random(30);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token
        ]);

        Mail::to($email)
        ->send(new ForgotPasswordEmail($token));
    }

    public function reset(string $token, string $newPassword): void
    {
        $resetPassword = DB::table('password_resets')
        ->where('token', $token)
        ->get()
        ->first();

        if (!$resetPassword) throw new Exception('Invalid token!');

        $user = User::where('email', $resetPassword->email)
        ->get()
        ->first();

        if (!$user) throw new Exception('User does not exists!');

        $user->password = Hash::make($newPassword);
        $user->save();
    }
}