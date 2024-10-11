<?php

namespace Dev\Base\Events;

use Dev\Base\Contracts\PanelSections\PanelSection;
use Illuminate\Foundation\Events\Dispatchable;

class PanelSectionRendered
{
    use Dispatchable;

    public function __construct(public PanelSection $section, public string $content)
    {
    }
}
