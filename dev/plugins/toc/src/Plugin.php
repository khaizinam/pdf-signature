<?php

namespace Plugin\ToC;

use Dev\Base\Models\MetaBox;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Dev\Setting\Models\Setting;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Setting::whereIn('key', ['plugin_toc_settings'])->delete();
        MetaBox::whereIn('meta_key', ['show_toc_in_content'])->delete();
    }
}
