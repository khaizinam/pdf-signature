<?php

namespace Dev\SeoHelper\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\SeoHelper\Contracts\SeoHelperContract;
use Dev\SeoHelper\Contracts\SeoMetaContract;
use Dev\SeoHelper\Contracts\SeoOpenGraphContract;
use Dev\SeoHelper\Contracts\SeoTwitterContract;
use Dev\SeoHelper\SeoHelper;
use Dev\SeoHelper\SeoMeta;
use Dev\SeoHelper\SeoOpenGraph;
use Dev\SeoHelper\SeoTwitter;

/**
 * @since 02/12/2015 14:09 PM
 */
class SeoHelperServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(SeoMetaContract::class, SeoMeta::class);
        $this->app->bind(SeoHelperContract::class, SeoHelper::class);
        $this->app->bind(SeoOpenGraphContract::class, SeoOpenGraph::class);
        $this->app->bind(SeoTwitterContract::class, SeoTwitter::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/seo-helper')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->register(EventServiceProvider::class);
        $this->app->register(HookServiceProvider::class);
    }
}
