<?php

namespace Dev\EditLock\Providers;

use Dev\Base\Events\BeforeEditContentEvent;
use Dev\Base\Events\BeforeUpdateContentEvent;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\EditLock\Listeners\BeforeEditContentListener;
use Dev\EditLock\Listeners\BeforeUpdateContentListener;
use Dev\EditLock\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BeforeEditContentEvent::class => [
            BeforeEditContentListener::class,
        ],
        BeforeUpdateContentEvent::class => [
            BeforeUpdateContentListener::class,
        ],
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
    ];
}
