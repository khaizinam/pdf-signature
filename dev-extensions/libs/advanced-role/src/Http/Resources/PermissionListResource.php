<?php

namespace Dev\AdvancedRole\Http\Resources;

use Dev\ACL\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class PermissionListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'reference_type' => $this->reference_type,
            'allowed_scopes' => $this->allowed_scopes,
            'alias' => $this->alias,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
