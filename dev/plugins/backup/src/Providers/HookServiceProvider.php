<?php

namespace Dev\Backup\Providers;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Supports\ServiceProvider;
use Dev\Dashboard\Events\RenderingDashboardWidgets;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app['events']->listen(RenderingDashboardWidgets::class, function () {
            add_filter(DASHBOARD_FILTER_ADMIN_NOTIFICATIONS, [$this, 'registerAdminAlert'], 5);
        });
    }

    public function registerAdminAlert(?string $alert): string
    {
        if (! BaseHelper::hasDemoModeEnabled()) {
            return $alert;
        }

        return $alert . view('plugins/backup::partials.admin-alert')->render();
    }
}
