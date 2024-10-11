<?php

namespace Dev\Dashboard\Repositories\Eloquent;

use Dev\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardWidgetSettingRepository extends RepositoriesAbstract implements DashboardWidgetSettingInterface
{
    public function getListWidget(): Collection
    {
        $data = $this->model
            ->select([
                'id',
                'order',
                'settings',
                'widget_id',
            ])
            ->with('widget')
            ->orderBy('order')
            ->where('user_id', Auth::guard()->id())
            ->get();

        $this->resetModel();

        return $data;
    }
}
