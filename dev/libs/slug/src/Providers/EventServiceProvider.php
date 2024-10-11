<?php

namespace Dev\Slug\Providers;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Events\FinishedSeederEvent;
use Dev\Base\Events\SeederPrepared;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\Slug\Listeners\CreatedContentListener;
use Dev\Slug\Listeners\CreateMissingSlug;
use Dev\Slug\Listeners\DeletedContentListener;
use Dev\Slug\Listeners\TruncateSlug;
use Dev\Slug\Listeners\UpdatedContentListener;
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
        SeederPrepared::class => [
            TruncateSlug::class,
        ],
        FinishedSeederEvent::class => [
            CreateMissingSlug::class,
        ],
    ];
}
