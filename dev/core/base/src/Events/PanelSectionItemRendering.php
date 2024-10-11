<?php

namespace Dev\Base\Events;

use Dev\Base\Contracts\PanelSections\PanelSectionItem;
use Illuminate\Foundation\Events\Dispatchable;

class PanelSectionItemRendering
{
    use Dispatchable;

    public function __construct(public PanelSectionItem $item)
    {
    }
}
