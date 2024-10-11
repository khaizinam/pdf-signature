<?php

namespace Dev\LogViewer\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\Manager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\PanelSections\System\SystemPanelSection;
use Dev\LogViewer\LogViewer;
use Illuminate\Routing\Events\RouteMatched;
use Dev\Base\Supports\Helper;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;
use Dev\LogViewer\Contracts;
use Dev\LogViewer\Utilities;

class LogViewerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind('dev::log-viewer', LogViewer::class);

        Helper::autoload(__DIR__ . '/../../helpers');

        $this->app->singleton('dev::log-viewer.levels', function ($app) {
            return new Utilities\LogLevels($app['translator'], config('plugins.log-viewer.general.locale'));
        });
        $this->app->bind(Contracts\Utilities\LogLevels::class, 'dev::log-viewer.levels');

        $this->app->singleton('dev::log-viewer.styler', Utilities\LogStyler::class);
        $this->app->bind(Contracts\Utilities\LogStyler::class, 'dev::log-viewer.styler');

        $this->app->singleton('dev::log-viewer.menu', Utilities\LogMenu::class);
        $this->app->bind(Contracts\Utilities\LogMenu::class, 'dev::log-viewer.menu');

        $this->app->singleton('dev::log-viewer.filesystem', function ($app) {
            $filesystem = new Utilities\Filesystem($app['files'], config('plugins.log-viewer.general.storage-path'));

            $filesystem->setPattern(
                config('plugins.log-viewer.general.pattern.prefix', Utilities\Filesystem::PATTERN_PREFIX),
                config('plugins.log-viewer.general.pattern.date', Utilities\Filesystem::PATTERN_DATE),
                config('plugins.log-viewer.general.pattern.extension', Utilities\Filesystem::PATTERN_EXTENSION)
            );

            return $filesystem;
        });
        $this->app->bind(Contracts\Utilities\Filesystem::class, 'dev::log-viewer.filesystem');

        $this->app->singleton('dev::log-viewer.factory', Utilities\Factory::class);
        $this->app->bind(Contracts\Utilities\Factory::class, 'dev::log-viewer.factory');

        $this->app->singleton('dev::log-viewer.checker', Utilities\LogChecker::class);
        $this->app->bind(Contracts\Utilities\LogChecker::class, 'dev::log-viewer.checker');
    }

    public function boot()
    {
        $this->setNamespace('plugins/log-viewer')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        if (version_compare('7.0.0', get_core_version(), '>=')) {
            $this->app['events']->listen(RouteMatched::class, function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugin-log-viewer',
                    'priority' => 7,
                    'parent_id' => 'cms-core-platform-administration',
                    'name' => 'plugins/log-viewer::log-viewer.system_logs',
                    'icon' => null,
                    'url' => route('log-viewer::logs.index'),
                    'permissions' => ['log-viewer::logs.index'],
                ]);
            });
        } else {
            PanelSectionManager::group('system')->beforeRendering(function (Manager $manager) {
                $manager
                    ->registerItem(
                        SystemPanelSection::class,
                        fn() => PanelSectionItem::make('system.log-viewer')
                            ->setTitle(trans('plugins/log-viewer::log-viewer.system_logs'))
                            ->withDescription(trans('plugins/log-viewer::log-viewer.system_logs_description'))
                            ->withIcon('ti ti-report')
                            ->withPriority(9980)
                            ->withRoute('log-viewer::logs.index')
                    );
            });
        }
    }
}
