<?php

namespace Dev\AdvancedRole\Http\Resources;

use Dev\ACL\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Dev\Auth\Http\Resources\UserResource;

/**
 * @mixin User
 */
class RoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'display_name' => $this->display_name,
            'name' => $this->name,
            'permissions' => $this->permissions,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
