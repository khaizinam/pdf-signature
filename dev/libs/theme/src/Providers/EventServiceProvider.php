<?php

namespace Dev\Theme\Providers;

use Dev\Base\Events\FormRendering;
use Dev\Base\Events\SeederPrepared;
use Dev\Base\Events\SystemUpdateDBMigrated;
use Dev\Base\Events\SystemUpdatePublished;
use Dev\Theme\Listeners\AddFormJsValidation;
use Dev\Theme\Listeners\CoreUpdateThemeDB;
use Dev\Theme\Listeners\PublishThemeAssets;
use Dev\Theme\Listeners\SetDefaultTheme;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SystemUpdateDBMigrated::class => [
            CoreUpdateThemeDB::class,
        ],
        SystemUpdatePublished::class => [
            PublishThemeAssets::class,
        ],
        SeederPrepared::class => [
            SetDefaultTheme::class,
        ],
        FormRendering::class => [
            AddFormJsValidation::class,
        ],
    ];
}
