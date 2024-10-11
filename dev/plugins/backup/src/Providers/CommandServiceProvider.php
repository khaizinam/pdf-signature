<?php

namespace Dev\Backup\Providers;

use Dev\Backup\Commands\BackupCleanCommand;
use Dev\Backup\Commands\BackupCreateCommand;
use Dev\Backup\Commands\BackupListCommand;
use Dev\Backup\Commands\BackupRemoveCommand;
use Dev\Backup\Commands\BackupRestoreCommand;
use Dev\Base\Supports\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            BackupCreateCommand::class,
            BackupRestoreCommand::class,
            BackupRemoveCommand::class,
            BackupListCommand::class,
            BackupCleanCommand::class,
        ]);
    }
}
