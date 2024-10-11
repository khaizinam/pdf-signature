<?php

namespace Dev\LanguageAdvanced\Listeners;

use Dev\Base\Facades\BaseHelper;
use Dev\LanguageAdvanced\Plugin;
use Exception;

class PriorityLanguageAdvancedPluginListener
{
    public function handle(): void
    {
        try {
            Plugin::activated();
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}
