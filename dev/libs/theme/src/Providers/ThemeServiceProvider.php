<?php

namespace Dev\Theme\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\DashboardMenu as DashboardMenuSupport;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Setting\PanelSections\SettingCommonPanelSection;
use Dev\Theme\Commands\ThemeActivateCommand;
use Dev\Theme\Commands\ThemeAssetsPublishCommand;
use Dev\Theme\Commands\ThemeAssetsRemoveCommand;
use Dev\Theme\Commands\ThemeOptionCheckMissingCommand;
use Dev\Theme\Commands\ThemeRemoveCommand;
use Dev\Theme\Commands\ThemeRenameCommand;
use Dev\Theme\Contracts\Theme as ThemeContract;
use Dev\Theme\Events\RenderingAdminBar;
use Dev\Theme\Theme;

class ThemeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->singleton(ThemeContract::class, Theme::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/theme')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadHelpers()
            ->loadRoutes()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function (DashboardMenuSupport $menu) {
            $config = $this->app['config'];

            $menu
                ->registerItem([
                    'id' => 'cms-core-appearance',
                    'priority' => 2000,
                    'parent_id' => null,
                    'name' => 'libs/theme::theme.appearance',
                    'icon' => 'ti ti-brush',
                    'url' => '#',
                    'permissions' => [],
                ])
                ->when(
                    $config->get('libs.theme.general.display_theme_manager_in_admin_panel', true),
                    function (DashboardMenuSupport $menu) {
                        $menu->registerItem([
                            'id' => 'cms-core-theme',
                            'priority' => 1,
                            'parent_id' => 'cms-core-appearance',
                            'name' => 'libs/theme::theme.name',
                            'icon' => null,
                            'url' => fn () => route('theme.index'),
                            'permissions' => ['theme.index'],
                        ]);
                    }
                )
                ->registerItem([
                    'id' => 'cms-core-theme-option',
                    'priority' => 4,
                    'parent_id' => 'cms-core-appearance',
                    'name' => 'libs/theme::theme.theme_options',
                    'icon' => null,
                    'url' => fn () => route('theme.options'),
                    'permissions' => ['theme.options'],
                ])
                ->registerItem([
                    'id' => 'cms-core-appearance-custom-css',
                    'priority' => 5,
                    'parent_id' => 'cms-core-appearance',
                    'name' => 'libs/theme::theme.custom_css',
                    'icon' => null,
                    'url' => fn () => route('theme.custom-css'),
                    'permissions' => ['theme.custom-css'],
                ])
                ->when(
                    $config->get('libs.theme.general.enable_custom_js'),
                    function (DashboardMenuSupport $menu) {
                        $menu->registerItem([
                            'id' => 'cms-core-appearance-custom-js',
                            'priority' => 6,
                            'parent_id' => 'cms-core-appearance',
                            'name' => 'libs/theme::theme.custom_js',
                            'icon' => null,
                            'url' => fn () => route('theme.custom-js'),
                            'permissions' => ['theme.custom-js'],
                        ]);
                    }
                )
                ->when(
                    $config->get('libs.theme.general.enable_custom_html'),
                    function (DashboardMenuSupport $menu) {
                        $menu->registerItem([
                            'id' => 'cms-core-appearance-custom-html',
                            'priority' => 6,
                            'parent_id' => 'cms-core-appearance',
                            'name' => 'libs/theme::theme.custom_html',
                            'icon' => null,
                            'url' => fn () => route('theme.custom-html'),
                            'permissions' => ['theme.custom-html'],
                        ]);
                    }
                )
                ->when(
                    $config->get('libs.theme.general.enable_robots_txt_editor'),
                    function (DashboardMenuSupport $menu) {
                        $menu->registerItem([
                            'id' => 'cms-core-appearance-robots-txt',
                            'priority' => 6,
                            'parent_id' => 'cms-core-appearance',
                            'name' => 'libs/theme::theme.robots_txt_editor',
                            'icon' => null,
                            'url' => fn () => route('theme.robots-txt'),
                            'permissions' => ['theme.robots-text'],
                        ]);
                    }
                );
        });

        PanelSectionManager::default()->beforeRendering(function () {
            PanelSectionManager::registerItem(
                SettingCommonPanelSection::class,
                fn () => PanelSectionItem::make('website_tracking')
                    ->setTitle(trans('libs/theme::theme.settings.website_tracking.title'))
                    ->withIcon('ti ti-world')
                    ->withDescription(trans('libs/theme::theme.settings.website_tracking.description'))
                    ->withPriority(140)
                    ->withRoute('settings.website-tracking'),
            );
        });

        $this->app['events']->listen(RenderingAdminBar::class, function () {
            admin_bar()
                ->registerLink(trans('libs/theme::theme.name'), route('theme.index'), 'appearance', 'theme.index')
                ->registerLink(
                    trans('libs/theme::theme.theme_options'),
                    route('theme.options'),
                    'appearance',
                    'theme.options'
                );
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });

        $this->app->register(ThemeManagementServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ThemeActivateCommand::class,
                ThemeRemoveCommand::class,
                ThemeAssetsPublishCommand::class,
                ThemeOptionCheckMissingCommand::class,
                ThemeAssetsRemoveCommand::class,
                ThemeRenameCommand::class,
            ]);
        }
    }
}
