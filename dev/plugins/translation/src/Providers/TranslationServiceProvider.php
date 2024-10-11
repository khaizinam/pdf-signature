<?php

namespace Dev\Translation\Providers;

use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\DataSynchronize\PanelSections\ExportPanelSection;
use Dev\DataSynchronize\PanelSections\ImportPanelSection;
use Dev\Translation\Console\AutoTranslateCoreCommand;
use Dev\Translation\Console\AutoTranslateThemeCommand;
use Dev\Translation\Console\DownloadLocaleCommand;
use Dev\Translation\Console\RemoveLocaleCommand;
use Dev\Translation\Console\RemoveUnusedTranslationsCommand;
use Dev\Translation\Console\UpdateThemeTranslationCommand;
use Dev\Translation\PanelSections\LocalizationPanelSection;

class TranslationServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/translation')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadMigrations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        PanelSectionManager::beforeRendering(function () {
            PanelSectionManager::register(LocalizationPanelSection::class);
        });

        PanelSectionManager::setGroupId('data-synchronize')->beforeRendering(function () {
            PanelSectionManager::default()
                ->registerItem(
                    ExportPanelSection::class,
                    fn () => PanelSectionItem::make('export-theme-translations')
                        ->setTitle(trans('plugins/translation::translation.panel.theme-translations.title'))
                        ->withDescription(trans(
                            'plugins/translation::translation.export_description',
                            ['name' => trans('plugins/translation::translation.panel.theme-translations.title')]
                        ))
                        ->withPriority(999)
                        ->withPermission('theme-translations.export')
                        ->withRoute('tools.data-synchronize.export.theme-translations.index')
                )
                ->registerItem(
                    ExportPanelSection::class,
                    fn () => PanelSectionItem::make('other-translations')
                        ->setTitle(trans('plugins/translation::translation.panel.admin-translations.title'))
                        ->withDescription(trans(
                            'plugins/translation::translation.export_description',
                            ['name' => trans('plugins/translation::translation.panel.admin-translations.title')]
                        ))
                        ->withPriority(999)
                        ->withPermission('other-translations.export')
                        ->withRoute('tools.data-synchronize.export.other-translations.index')
                )
                ->registerItem(
                    ImportPanelSection::class,
                    fn () => PanelSectionItem::make('import-theme-translations')
                        ->setTitle(trans('plugins/translation::translation.panel.theme-translations.title'))
                        ->withDescription(trans(
                            'plugins/translation::translation.import_description',
                            ['name' => trans('plugins/translation::translation.panel.theme-translations.title')]
                        ))
                        ->withPriority(999)
                        ->withPermission('theme-translations.import')
                        ->withRoute('tools.data-synchronize.import.theme-translations.index')
                )
                ->registerItem(
                    ImportPanelSection::class,
                    fn () => PanelSectionItem::make('other-translations')
                        ->setTitle(trans('plugins/translation::translation.panel.admin-translations.title'))
                        ->withDescription(trans(
                            'plugins/translation::translation.import_description',
                            ['name' => trans('plugins/translation::translation.panel.admin-translations.title')]
                        ))
                        ->withPriority(999)
                        ->withPermission('other-translations.import')
                        ->withRoute('tools.data-synchronize.import.other-translations.index')
                );
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdateThemeTranslationCommand::class,
                RemoveUnusedTranslationsCommand::class,
                DownloadLocaleCommand::class,
                RemoveLocaleCommand::class,
                AutoTranslateThemeCommand::class,
                AutoTranslateCoreCommand::class,
            ]);
        }
    }
}
