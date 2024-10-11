<?php

namespace Dev\Backup\Providers;

use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\PanelSections\System\SystemPanelSection;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;

class BackupServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/backup')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->register(CommandServiceProvider::class);

        PanelSectionManager::group('system')->beforeRendering(function () {
            PanelSectionManager::registerItem(
                SystemPanelSection::class,
                fn () => PanelSectionItem::make('backup')
                    ->setTitle(trans('plugins/backup::backup.name'))
                    ->withIcon('ti ti-database-share')
                    ->withDescription(trans('plugins/backup::backup.backup_description'))
                    ->withPriority(30)
                    ->withRoute('backups.index')
            );
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
