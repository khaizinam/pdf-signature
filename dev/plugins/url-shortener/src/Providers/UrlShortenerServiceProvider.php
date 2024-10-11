<?php

namespace ArchiElite\UrlShortener\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;

class UrlShortenerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/url-shortener')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-url_shortener',
                'priority' => 920,
                'name' => 'plugins/url-shortener::url-shortener.name',
                'icon' => 'ti ti-link',
                'route' => 'url_shortener.index',
            ]);
        });
    }
}
