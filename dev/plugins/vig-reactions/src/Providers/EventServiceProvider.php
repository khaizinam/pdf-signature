<?php

namespace Dev\VigReactions\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Dev\VigReactions\Http\Listeners\CreateOrUpdateReactionListener;
use Dev\VigReactions\Http\Events\CreateOrUpdateReactionEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CreateOrUpdateReactionEvent::class => [
            CreateOrUpdateReactionListener::class,
        ],
    ];
}
