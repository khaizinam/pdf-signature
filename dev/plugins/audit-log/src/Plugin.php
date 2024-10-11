<?php

namespace Dev\AuditLog;

use Dev\Dashboard\Models\DashboardWidget;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Dev\Widget\Models\Widget;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('audit_histories');

        Widget::query()
            ->where('widget_id', 'widget_audit_logs')
            ->each(fn (DashboardWidget $dashboardWidget) => $dashboardWidget->delete());
    }
}
