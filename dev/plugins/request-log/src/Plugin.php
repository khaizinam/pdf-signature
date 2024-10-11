<?php

namespace Dev\RequestLog;

use Dev\Dashboard\Models\DashboardWidget;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Dev\Widget\Models\Widget;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('request_logs');

        Widget::query()
            ->where('widget_id', 'widget_request_errors')
            ->each(fn (DashboardWidget $dashboardWidget) => $dashboardWidget->delete());
    }
}
