<?php

namespace Dev\Menu\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Menu\Models\Menu as MenuModel;
use Dev\Menu\Models\MenuLocation;
use Dev\Menu\Models\MenuNode;
use Dev\Menu\Repositories\Eloquent\MenuLocationRepository;
use Dev\Menu\Repositories\Eloquent\MenuNodeRepository;
use Dev\Menu\Repositories\Eloquent\MenuRepository;
use Dev\Menu\Repositories\Interfaces\MenuInterface;
use Dev\Menu\Repositories\Interfaces\MenuLocationInterface;
use Dev\Menu\Repositories\Interfaces\MenuNodeInterface;
use Dev\Theme\Events\RenderingAdminBar;
use Dev\Theme\Facades\AdminBar;

class MenuServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(MenuInterface::class, function () {
            return new MenuRepository(new MenuModel());
        });

        $this->app->bind(MenuNodeInterface::class, function () {
            return new MenuNodeRepository(new MenuNode());
        });

        $this->app->bind(MenuLocationInterface::class, function () {
            return new MenuLocationRepository(new MenuLocation());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/menu')
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-menu',
                    'priority' => 2,
                    'parent_id' => 'cms-core-appearance',
                    'name' => 'libs/menu::menu.name',
                    'route' => 'menus.index',
                ]);
        });

        $this->app['events']->listen(RenderingAdminBar::class, function () {
            AdminBar::registerLink(
                trans('libs/menu::menu.name'),
                route('menus.index'),
                'appearance',
                'menus.index'
            );
        });

        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
    }
}
