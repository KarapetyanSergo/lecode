<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\CreatePostRequest;
use App\Http\Services\PostService;
use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(CreatePostRequest $request, PostService $postService): JsonResponse
    {
        try {
            return response()->json($this->successResponse($postService->createPost($request)));
        } catch (Exception $e) {
            return response()->json($this->errorResponse($e->getMessage()), 400);
        }
    }

    public function index(Request $request): JsonResponse
    {
        $response = Post::when($request->user_id, function($q) use($request) {
            $q->where('user_id', $request->user_id);
        })->paginate($request->page_size, ['*'], 'page', $request->page);

        return response()->json($this->successResponse($response));
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json($this->successResponse($post));
    }
}
