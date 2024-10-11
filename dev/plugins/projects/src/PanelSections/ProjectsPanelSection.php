<?php

namespace Dev\Projects\PanelSections;

use Dev\Base\PanelSections\PanelSection;

class ProjectsPanelSection extends PanelSection
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
