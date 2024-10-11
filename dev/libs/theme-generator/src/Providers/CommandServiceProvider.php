<?php

namespace Dev\ThemeGenerator\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\ThemeGenerator\Commands\ThemeCreateCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ThemeCreateCommand::class,
            ]);
        }
    }
}
