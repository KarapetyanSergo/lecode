<?php

namespace App\Http\Services;

use App\Http\Requests\Api\Post\CreatePostRequest;
use App\Models\Post;

class PostService
{
    public function createPost(CreatePostRequest $request): Post
    {
        $file = $request->file('image');
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path('public/Images/Posts'), $filename);

        return Post::create([
            'user_id' => auth()->user()->id,
            'image' => $filename,
        ]);
    }
}