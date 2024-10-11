<?php

namespace Dev\DataSynchronize\PanelSections;

use Dev\Base\PanelSections\PanelSection;

class ImportPanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('data-synchronize-import')
            ->setTitle(trans('libs/data-synchronize::data-synchronize.import.name'))
            ->withPriority(99999);
    }
}
