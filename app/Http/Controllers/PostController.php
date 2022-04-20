<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['posts' => Post::all()]);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }
}
