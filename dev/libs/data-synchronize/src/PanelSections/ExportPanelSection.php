<?php

namespace Dev\DataSynchronize\PanelSections;

use Dev\Base\PanelSections\PanelSection;

class ExportPanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('data-synchronize-export')
            ->setTitle(trans('libs/data-synchronize::data-synchronize.export.name'))
            ->withPriority(99999);
    }
}
