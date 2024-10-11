<?php

namespace Dev\PluginManager\Events;

use Dev\ACL\Models\User;

class PluginUpdated
{
    public function __construct(public User $actor, public string $package)
    {
    }
}
