<?php

namespace Dev\ACL\Providers;

use Dev\ACL\Commands\UserCreateCommand;
use Dev\ACL\Commands\UserPasswordCommand;
use Dev\Base\Supports\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            UserCreateCommand::class,
            UserPasswordCommand::class,
        ]);
    }
}
