<?php

namespace Dev\Base\Events;

use Dev\Base\Supports\DashboardMenu;
use Illuminate\Foundation\Events\Dispatchable;

class DashboardMenuRetrieving
{
    use Dispatchable;

    public function __construct(
        public DashboardMenu $dashboardMenu
    ) {
    }
}
