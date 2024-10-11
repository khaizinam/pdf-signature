<?php

namespace Dev\PluginGenerator\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\PluginGenerator\Commands\PluginCreateCommand;
use Dev\PluginGenerator\Commands\PluginMakeCrudCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PluginCreateCommand::class,
                PluginMakeCrudCommand::class,
            ]);
        }
    }
}
