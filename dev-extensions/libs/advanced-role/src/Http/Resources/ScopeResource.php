<?php

namespace Dev\AdvancedRole\Http\Resources;

use Dev\ACL\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Dev\Auth\Http\Resources\UserResource;

/**
 * @mixin User
 */
class ScopeResource extends JsonResource
{
    public function toArray($request): array
    {
        /**
         * Global: cho phép truy cập toàn bộ records/ resource tất cả phòng ban; 
         * Deep: cho phép truy cập các records/ resource trong phòng ban trực thuộc và các phòng ban con của phòng ban đó; 
         * Local: chỉ cho phép truy cập các records/ resource trong phòng ban trực thuộc; 
         * Basic: chỉ cho phép truy cập các records/ resource đang được assign;None: không có quyền truy cập)
         * */
        return [
            'id' => $this->id,
            'name' => $this->name, // it is scope's name, enum('none','basic','local','deep','global')
            'display_name' => $this->display_name,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
