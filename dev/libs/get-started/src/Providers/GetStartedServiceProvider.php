<?php

namespace Dev\GetStarted\Providers;

use Dev\Base\Facades\Assets;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Dashboard\Events\RenderingDashboardWidgets;
use Illuminate\Support\Facades\Auth;

class GetStartedServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('libs/get-started')
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadRoutes()
            ->loadAndPublishViews();

        $this->app['events']->listen(RenderingDashboardWidgets::class, function () {
            add_action(DASHBOARD_ACTION_REGISTER_SCRIPTS, function () {
                if ($this->shouldShowGetStartedPopup()) {
                    Assets::addScriptsDirectly('vendor/core/libs/get-started/js/get-started.js')
                        ->addStylesDirectly('vendor/core/libs/get-started/css/get-started.css')
                        ->addScripts('jquery-ui');

                    add_filter(BASE_FILTER_FOOTER_LAYOUT_TEMPLATE, function ($html) {
                        return $html . view('libs/get-started::index')->render();
                    }, 120);

                    add_filter(DASHBOARD_FILTER_ADMIN_NOTIFICATIONS, function ($html) {
                        return $html . view('libs/get-started::setup-wizard-notice')->render();
                    }, 4);
                }
            }, 234);
        });
    }

    protected function shouldShowGetStartedPopup(): bool
    {
        return ! BaseHelper::hasDemoModeEnabled() &&
            is_in_admin(true) &&
            Auth::guard()->check() &&
            setting('is_completed_get_started') != '1';
    }
}
