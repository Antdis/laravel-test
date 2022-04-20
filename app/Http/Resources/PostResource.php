<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Post $resource
 */
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->resource->id,
            'text'     => $this->resource->text,
            'img'      => $this->resource->img,
            'likes'    => $this->resource->likes,
            'comments' => $this->resource->comments,
            'user'     => $this->resource->user,
        ];
    }
}
