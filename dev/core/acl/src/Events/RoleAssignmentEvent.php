<?php

namespace Dev\ACL\Events;

use Dev\ACL\Models\Role;
use Dev\ACL\Models\User;
use Dev\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleAssignmentEvent extends Event
{
    use SerializesModels;

    public function __construct(public Role $role, public User $user)
    {
    }
}
