<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Post $resource
 */
class PostResource extends JsonResource
{
    public static $wrap = 'post';

    public function toArray($request)
    {
        return [
            'id'       => $this->resource->id,
            'text'     => $this->resource->text,
            'img'      => $this->resource->img,
            'likes'    => $this->resource->likes,
            'comments' => $this->resource->comments->map(function (Comment $comment) {
                return [
                    'id'    => $comment->id,
                    'text'  => $comment->text,
                    'user'  => $this->getUserFields($comment->user),
                    'likes' => $comment->likes,
                ];
            }),
            'user'     => $this->getUserFields($this->resource->user),
        ];
    }

    private function getUserFields(User $user)
    {
        return [
            'avatarfull'  => $user->avatarfull,
            'personaname' => $user->personaname,
        ];
    }
}
