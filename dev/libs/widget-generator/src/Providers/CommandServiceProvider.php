<?php

namespace Dev\WidgetGenerator\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\WidgetGenerator\Commands\WidgetCreateCommand;
use Dev\WidgetGenerator\Commands\WidgetRemoveCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                WidgetCreateCommand::class,
                WidgetRemoveCommand::class,
            ]);
        }
    }
}
