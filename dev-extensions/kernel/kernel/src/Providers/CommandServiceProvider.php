<?php

namespace Dev\Kernel\Providers;

use Illuminate\Support\ServiceProvider;

use Dev\Kernel\Commands\MemberBirthdayNotificationCommand;
use Dev\Kernel\Commands\TestCommand;
use Dev\Kernel\Commands\MssqlCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (app()->runningInConsole()) {
            $this->commands([
                TestCommand::class,
                MemberBirthdayNotificationCommand::class,
                MssqlCommand::class
            ]);
        }
    }
}
