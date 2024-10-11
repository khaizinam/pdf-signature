<?php

namespace Dev\Member\Providers;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Member\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
    ];
}
