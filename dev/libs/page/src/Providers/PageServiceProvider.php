<?php

namespace Dev\Page\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Page\Models\Page;
use Dev\Page\Repositories\Eloquent\PageRepository;
use Dev\Page\Repositories\Interfaces\PageInterface;
use Dev\Shortcode\View\View;
use Dev\Theme\Events\RenderingAdminBar;
use Dev\Theme\Facades\AdminBar;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * @since 02/07/2016 09:50 AM
 */
class PageServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->app->bind(PageInterface::class, function () {
            return new PageRepository(new Page());
        });

        $this
            ->setNamespace('libs/page')
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadHelpers()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadMigrations();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-page',
                    'priority' => 2,
                    'name' => 'libs/page::pages.menu_name',
                    'icon' => 'ti ti-notebook',
                    'route' => 'pages.index',
                ]);
        });

        $this->app['events']->listen(RenderingAdminBar::class, function () {
            AdminBar::registerLink(
                trans('libs/page::pages.menu_name'),
                route('pages.create'),
                'add-new',
                'pages.create'
            );
        });

        if (function_exists('shortcode')) {
            ViewFacade::composer(['libs/page::themes.page'], function (View $view) {
                $view->withShortcodes();
            });
        }

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });

        $this->app->register(EventServiceProvider::class);
    }
}
