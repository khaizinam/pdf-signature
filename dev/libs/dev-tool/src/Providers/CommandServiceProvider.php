<?php

namespace Dev\DevTool\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\DevTool\Commands\LocaleCreateCommand;
use Dev\DevTool\Commands\LocaleRemoveCommand;
use Dev\DevTool\Commands\Make\ControllerMakeCommand;
use Dev\DevTool\Commands\Make\FormMakeCommand;
use Dev\DevTool\Commands\Make\ModelMakeCommand;
use Dev\DevTool\Commands\Make\PanelSectionMakeCommand;
use Dev\DevTool\Commands\Make\RequestMakeCommand;
use Dev\DevTool\Commands\Make\RouteMakeCommand;
use Dev\DevTool\Commands\Make\SettingControllerMakeCommand;
use Dev\DevTool\Commands\Make\SettingFormMakeCommand;
use Dev\DevTool\Commands\Make\SettingMakeCommand;
use Dev\DevTool\Commands\Make\SettingRequestMakeCommand;
use Dev\DevTool\Commands\Make\TableMakeCommand;
use Dev\DevTool\Commands\PackageCreateCommand;
use Dev\DevTool\Commands\PackageMakeCrudCommand;
use Dev\DevTool\Commands\PackageRemoveCommand;
use Dev\DevTool\Commands\PluginCreateCommand;
use Dev\DevTool\Commands\PluginMakeCrudCommand;
use Dev\DevTool\Commands\RebuildPermissionsCommand;
use Dev\DevTool\Commands\TestSendMailCommand;
use Dev\DevTool\Commands\ThemeCreateCommand;
use Dev\DevTool\Commands\WidgetCreateCommand;
use Dev\DevTool\Commands\WidgetRemoveCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            TableMakeCommand::class,
            ControllerMakeCommand::class,
            RouteMakeCommand::class,
            RequestMakeCommand::class,
            FormMakeCommand::class,
            ModelMakeCommand::class,
            PackageCreateCommand::class,
            PackageMakeCrudCommand::class,
            PackageRemoveCommand::class,
            TestSendMailCommand::class,
            RebuildPermissionsCommand::class,
            LocaleRemoveCommand::class,
            LocaleCreateCommand::class,
        ]);

        if (version_compare(get_core_version(), '7.0.0', '>=')) {
            $this->commands([
                PanelSectionMakeCommand::class,
                SettingControllerMakeCommand::class,
                SettingRequestMakeCommand::class,
                SettingFormMakeCommand::class,
                SettingMakeCommand::class,
            ]);
        }

        if (class_exists(\Dev\PluginManagement\Providers\PluginManagementServiceProvider::class)) {
            $this->commands([
                PluginCreateCommand::class,
                PluginMakeCrudCommand::class,
            ]);
        }

        if (class_exists(\Dev\Theme\Providers\ThemeServiceProvider::class)) {
            $this->commands([
                ThemeCreateCommand::class,
            ]);
        }

        if (class_exists(\Dev\Widget\Providers\WidgetServiceProvider::class)) {
            $this->commands([
                WidgetCreateCommand::class,
                WidgetRemoveCommand::class,
            ]);
        }
    }
}
