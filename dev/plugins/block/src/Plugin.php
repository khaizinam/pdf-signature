<?php

namespace Dev\Block;

use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('blocks_translations');
    }
}
