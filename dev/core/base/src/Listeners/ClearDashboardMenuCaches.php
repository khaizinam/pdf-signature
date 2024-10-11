<?php

namespace Dev\Base\Listeners;

use Dev\Base\Facades\DashboardMenu;

class ClearDashboardMenuCaches
{
    public function handle(): void
    {
        DashboardMenu::clearCaches();
    }
}
