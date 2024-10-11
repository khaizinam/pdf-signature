<?php

namespace Dev\Optimize\Providers;

use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Optimize\Facades\OptimizerHelper;
use Dev\Optimize\Http\Middleware\CollapseWhitespace;
use Dev\Optimize\Http\Middleware\DeferJavascript;
use Dev\Optimize\Http\Middleware\ElideAttributes;
use Dev\Optimize\Http\Middleware\InlineCss;
use Dev\Optimize\Http\Middleware\InsertDNSPrefetch;
use Dev\Optimize\Http\Middleware\RemoveComments;
use Dev\Optimize\Http\Middleware\RemoveQuotes;
use Dev\Setting\PanelSections\SettingCommonPanelSection;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;

class OptimizeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('libs/optimize')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews();

        if (! class_exists('OptimizerHelper')) {
            AliasLoader::getInstance()->alias('OptimizerHelper', OptimizerHelper::class);
        }

        PanelSectionManager::default()->beforeRendering(function () {
            PanelSectionManager::registerItem(
                SettingCommonPanelSection::class,
                fn () => PanelSectionItem::make('common')
                    ->setTitle(trans('libs/optimize::optimize.settings.title'))
                    ->withIcon('ti ti-brand-speedtest')
                    ->withPriority(140)
                    ->withDescription(trans('libs/optimize::optimize.settings.description'))
                    ->withRoute('optimize.settings')
            );
        });

        $this->app['events']->listen(RouteMatched::class, function () {
            if (OptimizerHelper::isEnabled()) {
                /**
                 * @var Router $router
                 */
                $router = $this->app['router'];

                if (setting('optimize_elide_attributes', 0)) {
                    $router->pushMiddlewareToGroup('web', ElideAttributes::class);
                }

                if (setting('optimize_inline_css', 0)) {
                    $router->pushMiddlewareToGroup('web', InlineCss::class);
                }

                if (setting('optimize_insert_dns_prefetch', 0)) {
                    $router->pushMiddlewareToGroup('web', InsertDNSPrefetch::class);
                }

                if (setting('optimize_collapse_white_space', 0)) {
                    $router->pushMiddlewareToGroup('web', CollapseWhitespace::class);
                }

                if (setting('optimize_remove_comments', 0)) {
                    $router->pushMiddlewareToGroup('web', RemoveComments::class);
                }

                if (setting('optimize_remove_quotes', 0)) {
                    $router->pushMiddlewareToGroup('web', RemoveQuotes::class);
                }

                if (setting('optimize_defer_javascript', 0)) {
                    $router->pushMiddlewareToGroup('web', DeferJavascript::class);
                }
            }
        });
    }
}
