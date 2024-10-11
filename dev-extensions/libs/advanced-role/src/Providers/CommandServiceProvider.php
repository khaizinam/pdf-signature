<?php

namespace Dev\AdvancedRole\Providers;

use Dev\AdvancedRole\Commands\MssqlMemberMigrationCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // MssqlMemberMigrationCommand::class
            ]);
        }
    }
}
