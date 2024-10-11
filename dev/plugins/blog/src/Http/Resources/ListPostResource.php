<?php

namespace Dev\Blog\Http\Resources;

use Dev\Blog\Models\Post;
use Dev\Media\Facades\AppMedia;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Post
 */
class ListPostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image ? AppMedia::url($this->image) : null,
            'categories' => CategoryResource::collection($this->categories),
            'tags' => TagResource::collection($this->tags),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
