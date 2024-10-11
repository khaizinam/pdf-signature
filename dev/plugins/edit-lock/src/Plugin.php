<?php

namespace Dev\EditLock;

use Dev\Base\Models\MetaBox;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        MetaBox::where('meta_key', 'edit_lock')->delete();
    }
}
