<?php

namespace Dev\PluginManagement\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\PluginManagement\Commands\ClearCompiledCommand;
use Dev\PluginManagement\Commands\IlluminateClearCompiledCommand as OverrideIlluminateClearCompiledCommand;
use Dev\PluginManagement\Commands\PackageDiscoverCommand;
use Dev\PluginManagement\Commands\PluginActivateAllCommand;
use Dev\PluginManagement\Commands\PluginActivateCommand;
use Dev\PluginManagement\Commands\PluginAssetsPublishCommand;
use Dev\PluginManagement\Commands\PluginDeactivateAllCommand;
use Dev\PluginManagement\Commands\PluginDeactivateCommand;
use Dev\PluginManagement\Commands\PluginDiscoverCommand;
use Dev\PluginManagement\Commands\PluginInstallFromMarketplaceCommand;
use Dev\PluginManagement\Commands\PluginListCommand;
use Dev\PluginManagement\Commands\PluginRemoveAllCommand;
use Dev\PluginManagement\Commands\PluginRemoveCommand;
use Dev\PluginManagement\Commands\PluginUpdateVersionInfoCommand;
use Illuminate\Foundation\Console\ClearCompiledCommand as IlluminateClearCompiledCommand;
use Illuminate\Foundation\Console\PackageDiscoverCommand as IlluminatePackageDiscoverCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->extend(IlluminatePackageDiscoverCommand::class, function () {
            return $this->app->make(PackageDiscoverCommand::class);
        });

        $this->app->extend(IlluminateClearCompiledCommand::class, function () {
            return $this->app->make(OverrideIlluminateClearCompiledCommand::class);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PluginAssetsPublishCommand::class,
                ClearCompiledCommand::class,
                PluginDiscoverCommand::class,
                PluginInstallFromMarketplaceCommand::class,
                PluginActivateCommand::class,
                PluginActivateAllCommand::class,
                PluginDeactivateCommand::class,
                PluginDeactivateAllCommand::class,
                PluginRemoveCommand::class,
                PluginRemoveAllCommand::class,
                PluginListCommand::class,
                PluginUpdateVersionInfoCommand::class,
            ]);
        }
    }
}
