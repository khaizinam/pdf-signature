<?php

namespace Dev\Base\Events;

use Dev\Base\Contracts\PanelSections\Manager;
use Illuminate\Foundation\Events\Dispatchable;

class PanelSectionsRendering
{
    use Dispatchable;

    public function __construct(public Manager $panelSectionManager)
    {
    }
}
