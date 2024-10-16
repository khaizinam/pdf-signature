<?php

namespace Dev\Icon;

use Illuminate\Support\Manager;

class IconManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return 'svg';
    }

    public function createSvgDriver(): IconDriver
    {
        return app(SvgDriver::class)->setConfig(
            $this->config->get('core.icon.icon', [])
        );
    }
}
