<?php

namespace Dev\AdvancedRole\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Dev\AdvancedRole\Models\Role;

class RoleEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifyUser;
    public $notificationName;
    /**
     * @var Role
     */
    public $role;

    public function __construct(Role $role, $notifyUser, $notificationName)
    {
        $this->role = $role;
        $this->notifyUser = $notifyUser;
        $this->notificationName = $notificationName;
    }
}
