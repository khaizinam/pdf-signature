<?php

namespace Dev\AdvancedRole\Http\Resources;

use Dev\ACL\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Dev\Auth\Http\Resources\UserResource;

/**
 * @mixin User
 */
class TeamResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'author' => $this->author,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
