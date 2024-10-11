<?php

namespace Dev\Dashboard\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface DashboardWidgetSettingInterface extends RepositoryInterface
{
    public function getListWidget(): Collection;
}
