<?php

namespace Dev\Location\Providers;

use Dev\Location\Events\ImportedCityEvent;
use Dev\Location\Events\ImportedCountryEvent;
use Dev\Location\Events\ImportedStateEvent;
use Dev\Location\Listeners\CreateCityTranslationListener;
use Dev\Location\Listeners\CreateCountryTranslationListener;
use Dev\Location\Listeners\CreateStateTranslationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseServiceProvider;

class EventServiceProvider extends BaseServiceProvider
{
    protected $listen = [
        ImportedCountryEvent::class => [
            CreateCountryTranslationListener::class,
        ],
        ImportedStateEvent::class => [
            CreateStateTranslationListener::class,
        ],
        ImportedCityEvent::class => [
            CreateCityTranslationListener::class,
        ],
    ];
}
