<?php

namespace Dev\ACL\Providers;

use Dev\ACL\Events\RoleAssignmentEvent;
use Dev\ACL\Events\RoleUpdateEvent;
use Dev\ACL\Listeners\LoginListener;
use Dev\ACL\Listeners\RoleAssignmentListener;
use Dev\ACL\Listeners\RoleUpdateListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RoleUpdateEvent::class => [
            RoleUpdateListener::class,
        ],
        RoleAssignmentEvent::class => [
            RoleAssignmentListener::class,
        ],
        Login::class => [
            LoginListener::class,
        ],
    ];
}
