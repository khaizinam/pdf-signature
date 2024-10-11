<?php

namespace Dev\ContractManagement\PanelSections;

use Dev\Base\PanelSections\PanelSection;

class ContractManagementPanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('settings.{id}')
            ->setTitle('{title}')
            ->withItems([
                //
            ]);
    }
}
