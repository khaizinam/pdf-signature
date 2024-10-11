<?php

namespace Dev\Widget\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Theme\Events\RenderingAdminBar;
use Dev\Theme\Facades\AdminBar;
use Dev\Widget\Facades\WidgetGroup;
use Dev\Widget\Factories\WidgetFactory;
use Dev\Widget\Models\Widget;
use Dev\Widget\Repositories\Eloquent\WidgetRepository;
use Dev\Widget\Repositories\Interfaces\WidgetInterface;
use Dev\Widget\WidgetGroupCollection;
use Dev\Widget\Widgets\CoreSimpleMenu;
use Dev\Widget\Widgets\Text;
use Illuminate\Contracts\Foundation\Application;

class WidgetServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(WidgetInterface::class, function () {
            return new WidgetRepository(new Widget());
        });

        $this->app->bind('apps.widget', function (Application $app) {
            return new WidgetFactory($app);
        });

        $this->app->singleton('apps.widget-group-collection', function (Application $app) {
            return new WidgetGroupCollection($app);
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/widget')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadHelpers()
            ->loadRoutes()
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->booted(function () {
            WidgetGroup::setGroup([
                'id' => 'primary_sidebar',
                'name' => trans('libs/widget::widget.primary_sidebar_name'),
                'description' => trans('libs/widget::widget.primary_sidebar_description'),
            ]);

            register_widget(CoreSimpleMenu::class);
            register_widget(Text::class);
        });

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-widget',
                    'priority' => 3,
                    'parent_id' => 'cms-core-appearance',
                    'name' => 'libs/widget::widget.name',
                    'route' => 'widgets.index',
                ]);
        });

        $this->app['events']->listen(RenderingAdminBar::class, function () {
            AdminBar::registerLink(
                trans('libs/widget::widget.name'),
                route('widgets.index'),
                'appearance',
                'widgets.index'
            );
        });
    }
}
