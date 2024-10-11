<?php

namespace Dev\AdvancedRole\Listeners;

use Dev\AdvancedRole\Events\TeamEvent;

class TeamListener
{

    /**
     * Handle the event.
     *
     * @param TeamEvent $event
     * @return void
     */

    public function handle(TeamEvent $event)
    {
        if ($event->notificationName == 'TeamAssigned') {
        }
    }
}
