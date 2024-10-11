<?php

namespace Dev\Base\Events;

use Dev\Base\Contracts\PanelSections\PanelSection;
use Illuminate\Foundation\Events\Dispatchable;

class PanelSectionItemsRendering
{
    use Dispatchable;

    public function __construct(public PanelSection $section, public array $items)
    {
    }
}
