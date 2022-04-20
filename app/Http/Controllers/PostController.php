<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

    /**
     * Комментирование поста
     */
    public function comment(Request $request, Post $post)
    {
        $request->validate(['commentText' => 'required']);

        /** @var User $user */
        $user = auth()->user();

        $comment = new Comment();
        $comment->user()->associate($user);
        $comment->post()->associate($post);
        $comment->text  = $request->input('commentText');
        $comment->likes = 0;

        $comment->save();

        return new PostResource($post);
    }

    /**
     * Лайк комментария или поста
     */
    public function like(Request $request)
    {
        $request->validate([
            'type' => 'required|in:post,comment',
            'id'   => 'required|integer',
        ]);

        $type = $request->input('type');

        $builder = match ($type) {
            'post' => Post::query(),
            'comment' => Comment::query(),
        };

        $builder = $builder->where('id', $request->input('id'));

        DB::beginTransaction();

        try {
            /** @var User $user */
            $user = auth()->user();

            $affected = User::query()
                ->where('id', $user->id)
                ->where('likes_balance', '>=', 1)
                ->decrement('likes_balance');

            if (!$affected) {
                throw new \RuntimeException('Low like balance');
            }

            $isLiked = (clone $builder)->increment('likes');

            if (!$isLiked) {
                throw new \RuntimeException("Error on like $type");
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Выкидываем такое исключение, чтобы весь FRONT привести к одному формату ошибочных ответов
            throw ValidationException::withMessages(['like' => $e->getMessage()]);
        }

        /** @var Post|Comment $model */
        $model = $builder->first();

        if ($model instanceof Comment) {
            $post = $model->post;
        } else {
            $post = $model;
        }

        return new PostResource($post);
    }
}
