<?php

namespace Dev\Menu\Providers;

use Dev\Base\Events\DeletedContentEvent;
use Dev\Menu\Listeners\DeleteMenuNodeListener;
use Dev\Menu\Listeners\UpdateMenuNodeUrlListener;
use Dev\Slug\Events\UpdatedSlugEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedSlugEvent::class => [
            UpdateMenuNodeUrlListener::class,
        ],
        DeletedContentEvent::class => [
            DeleteMenuNodeListener::class,
        ],
    ];
}
