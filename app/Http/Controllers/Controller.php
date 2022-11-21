<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($data): array
    {
        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public function errorResponse($data): array
    {
        return [
            'success' => false,
            'data' => $data,
        ];
    }
}
