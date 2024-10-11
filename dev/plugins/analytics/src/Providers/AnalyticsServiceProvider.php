<?php

namespace Dev\Analytics\Providers;

use Dev\Analytics\Abstracts\AnalyticsAbstract;
use Dev\Analytics\Analytics;
use Dev\Analytics\Exceptions\InvalidConfiguration;
use Dev\Analytics\Facades\Analytics as AnalyticsFacade;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Setting\PanelSections\SettingOthersPanelSection;
use Illuminate\Foundation\AliasLoader;

class AnalyticsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(AnalyticsAbstract::class, function () {
            if (! ($credentials = setting('analytics_service_account_credentials'))) {
                throw InvalidConfiguration::credentialsIsNotValid();
            }

            if (! ($propertyId = setting('analytics_property_id')) || ! is_numeric($propertyId)) {
                throw InvalidConfiguration::invalidPropertyId();
            }

            return new Analytics($propertyId, $credentials);
        });

        AliasLoader::getInstance()->alias('Analytics', AnalyticsFacade::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/analytics')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        PanelSectionManager::default()->beforeRendering(function () {
            if (! config('plugins.analytics.general.enabled_dashboard_widgets', true)) {
                return;
            }

            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('analytics')
                    ->setTitle(trans('plugins/analytics::analytics.settings.title'))
                    ->withIcon('ti ti-brand-google-analytics')
                    ->withDescription(trans('plugins/analytics::analytics.settings.description'))
                    ->withPriority(160)
                    ->withRoute('analytics.settings')
            );
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
