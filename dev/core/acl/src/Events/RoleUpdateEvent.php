<?php

namespace Dev\ACL\Events;

use Dev\ACL\Models\Role;
use Dev\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleUpdateEvent extends Event
{
    use SerializesModels;

    public function __construct(public Role $role)
    {
    }
}
