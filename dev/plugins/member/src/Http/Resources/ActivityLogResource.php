<?php

namespace Dev\Member\Http\Resources;

use Dev\Member\Models\MemberActivityLog;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MemberActivityLog
 */
class ActivityLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getKey(),
            'ip_address' => $this->ip_address,
            'description' => $this->getDescription(),
        ];
    }
}
