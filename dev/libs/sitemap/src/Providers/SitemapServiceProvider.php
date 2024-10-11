<?php

namespace Dev\Sitemap\Providers;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Sitemap\Sitemap;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;

class SitemapServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    protected bool $defer = true;

    public function register(): void
    {
        $this->app->bind('sitemap', function (Application $app) {
            $config = $app['config']->get('libs.sitemap.config', []);

            return new Sitemap(
                $config,
                $app[Repository::class],
                $app['config'],
                $app['files'],
                $app[ResponseFactory::class],
                $app['view']
            );
        });

        $this->app->alias('sitemap', Sitemap::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/sitemap')
            ->loadAndPublishConfigurations(['config'])
            ->loadAndPublishViews()
            ->publishAssets();

        $this->app['events']->listen([
            CreatedContentEvent::class,
            UpdatedContentEvent::class,
            DeletedContentEvent::class,
        ], function () {
            $this->app['cache']->forget('cache_site_map_key');
        });
    }

    public function provides(): array
    {
        return ['sitemap', Sitemap::class];
    }
}
