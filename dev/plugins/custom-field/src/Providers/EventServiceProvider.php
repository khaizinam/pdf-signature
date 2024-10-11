<?php

namespace Dev\CustomField\Providers;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\CustomField\Listeners\CreatedContentListener;
use Dev\CustomField\Listeners\DeletedContentListener;
use Dev\CustomField\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
    ];
}
