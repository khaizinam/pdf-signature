<?php

namespace Dev\Location\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Location\Commands\MigrateLocationCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            MigrateLocationCommand::class,
        ]);
    }
}
