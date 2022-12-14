<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'required|file'
        ];
    }
}
