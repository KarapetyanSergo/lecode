<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file' => 'required|max:10000|mimes:txt',
            'symbol' => 'required',
        ];
    }
}
