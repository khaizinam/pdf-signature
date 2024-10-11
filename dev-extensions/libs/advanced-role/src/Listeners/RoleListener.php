<?php

namespace Dev\AdvancedRole\Listeners;

use Dev\AdvancedRole\Events\RoleEvent;

class RoleListener
{

    /**
     * Handle the event.
     *
     * @param RoleEvent $event
     * @return void
     */

    public function handle(RoleEvent $event)
    {
        if ($event->notificationName == 'RoleAssigned') {
        }
    }
}
