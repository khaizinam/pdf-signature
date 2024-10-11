<?php

namespace Dev\AdvancedRole\Providers;

#region Events

use Dev\AdvancedRole\Events\MemberEvent;
use Dev\AdvancedRole\Events\RoleEvent;
use Dev\AdvancedRole\Events\TeamEvent;
#endregion

#region Listeners
use Dev\AdvancedRole\Listeners\RoleListener;
use Dev\AdvancedRole\Listeners\TeamListener;
use Dev\AdvancedRole\Listeners\MemberListener;
#endregion

#region Models
use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Team;
use Dev\AdvancedRole\Models\Member;
#endregion

#region Observers
use Dev\AdvancedRole\Observers\RoleObserver;
use Dev\AdvancedRole\Observers\TeamObserver;
use Dev\AdvancedRole\Observers\MemberObserver;
#endregion

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RoleEvent::class => [RoleListener::class],
        TeamEvent::class => [TeamListener::class],
        MemberEvent::class => [MemberListener::class]

    ];

    protected $observers = [
        Role::class => [RoleObserver::class],
        Team::class => [TeamObserver::class],
        Member::class => [MemberObserver::class]
    ];
}
