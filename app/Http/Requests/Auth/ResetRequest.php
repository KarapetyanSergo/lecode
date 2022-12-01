<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token' => 'required',
            'password' => 'required|confirmed',
        ];
    }
}
