<?php

namespace Dev\PluginManagement\Providers;

use Dev\Base\Events\SeederPrepared;
use Dev\Base\Events\SystemUpdateDBMigrated;
use Dev\Base\Events\SystemUpdatePublished;
use Dev\Base\Listeners\ClearDashboardMenuCaches;
use Dev\PluginManagement\Events\ActivatedPluginEvent;
use Dev\PluginManagement\Listeners\ActivateAllPlugins;
use Dev\PluginManagement\Listeners\ClearPluginCaches;
use Dev\PluginManagement\Listeners\CoreUpdatePluginsDB;
use Dev\PluginManagement\Listeners\PublishPluginAssets;
use Illuminate\Contracts\Database\Events\MigrationEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MigrationEvent::class => [
            ClearPluginCaches::class,
        ],
        SystemUpdateDBMigrated::class => [
            CoreUpdatePluginsDB::class,
        ],
        SystemUpdatePublished::class => [
            PublishPluginAssets::class,
        ],
        SeederPrepared::class => [
            ActivateAllPlugins::class,
        ],
        ActivatedPluginEvent::class => [
            ClearDashboardMenuCaches::class,
        ],
    ];
}
