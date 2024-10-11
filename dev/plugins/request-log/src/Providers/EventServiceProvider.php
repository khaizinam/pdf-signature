<?php

namespace Dev\RequestLog\Providers;

use Dev\RequestLog\Events\RequestHandlerEvent;
use Dev\RequestLog\Listeners\RequestHandlerListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RequestHandlerEvent::class => [
            RequestHandlerListener::class,
        ],
    ];
}
