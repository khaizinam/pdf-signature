<?php

namespace Dev\AdvancedRole\Listeners;

use Dev\AdvancedRole\Events\MemberEvent;

class MemberListener
{

    /**
     * Handle the event.
     *
     * @param MemberEvent $event
     * @return void
     */

    public function handle(MemberEvent $event)
    {
        if ($event->notificationName == 'MemberAssigned') {
        }
    }
}
