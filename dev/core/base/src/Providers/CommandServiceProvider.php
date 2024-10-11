<?php

namespace Dev\Base\Providers;

use Dev\Base\Commands\ActivateLicenseCommand;
use Dev\Base\Commands\CleanupSystemCommand;
use Dev\Base\Commands\ClearExpiredCacheCommand;
use Dev\Base\Commands\ClearLogCommand;
use Dev\Base\Commands\ExportDatabaseCommand;
use Dev\Base\Commands\FetchGoogleFontsCommand;
use Dev\Base\Commands\GoogleFontsUpdateCommand;
use Dev\Base\Commands\ImportDatabaseCommand;
use Dev\Base\Commands\InstallCommand;
use Dev\Base\Commands\PublishAssetsCommand;
use Dev\Base\Commands\UpdateCommand;
use Dev\Base\Supports\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\AboutCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            ActivateLicenseCommand::class,
            CleanupSystemCommand::class,
            ClearExpiredCacheCommand::class,
            ClearLogCommand::class,
            ExportDatabaseCommand::class,
            FetchGoogleFontsCommand::class,
            ImportDatabaseCommand::class,
            InstallCommand::class,
            PublishAssetsCommand::class,
            UpdateCommand::class,
            GoogleFontsUpdateCommand::class,
        ]);

        AboutCommand::add('Core Information', fn () => [
            'CMS Version' => get_cms_version(),
            'Core Version' => get_core_version(),
        ]);

        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command(ClearExpiredCacheCommand::class)->everyFiveMinutes();
        });
    }
}
