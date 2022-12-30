<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadFileRequest;
use App\Http\Services\UploadFileService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class UploadFileController extends Controller
{
    public function upload(UploadFileRequest $request, UploadFileService $service): JsonResponse
    {
        try {
            $file = $request->file('file');
            $content = $service->readFile($file, $request->symbol);
            $file->move(public_path('public/Files'), date('YmdHi').$file->getFilename());

            return response()->json($this->successResponse($content));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }
}
