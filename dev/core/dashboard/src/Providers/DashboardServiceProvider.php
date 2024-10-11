<?php

namespace Dev\Dashboard\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Dashboard\Models\DashboardWidget;
use Dev\Dashboard\Models\DashboardWidgetSetting;
use Dev\Dashboard\Repositories\Eloquent\DashboardWidgetRepository;
use Dev\Dashboard\Repositories\Eloquent\DashboardWidgetSettingRepository;
use Dev\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Dev\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;

/**
 * @since 02/07/2016 09:50 AM
 */
class DashboardServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(DashboardWidgetInterface::class, function () {
            return new DashboardWidgetRepository(new DashboardWidget());
        });

        $this->app->bind(DashboardWidgetSettingInterface::class, function () {
            return new DashboardWidgetSettingRepository(new DashboardWidgetSetting());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('core/dashboard')
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadMigrations();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-dashboard',
                    'priority' => -9999,
                    'name' => 'core/base::layouts.dashboard',
                    'icon' => 'ti ti-home',
                    'route' => 'dashboard.index',
                    'permissions' => false,
                ]);
        });
    }
}
