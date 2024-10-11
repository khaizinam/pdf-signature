<?php

namespace Dev\Slug\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Slug\Commands\ChangeSlugPrefixCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            ChangeSlugPrefixCommand::class,
        ]);
    }
}
