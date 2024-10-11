<?php

namespace Dev\AuditLog\Providers;

use Dev\AuditLog\Commands\ActivityLogClearCommand;
use Dev\AuditLog\Commands\CleanOldLogsCommand;
use Dev\Base\Supports\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            ActivityLogClearCommand::class,
            CleanOldLogsCommand::class,
        ]);
    }
}
