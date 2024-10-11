<?php

namespace Dev\Menu\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Menu\Commands\ClearMenuCacheCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            ClearMenuCacheCommand::class,
        ]);
    }
}
