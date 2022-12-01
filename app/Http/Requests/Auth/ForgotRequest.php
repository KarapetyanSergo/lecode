<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|exists:App\Models\User,email',
        ];
    }
}
