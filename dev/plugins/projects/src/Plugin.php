<?php

namespace Dev\Projects;

use Illuminate\Support\Facades\Schema;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Projects');
        Schema::dropIfExists('Projects_translations');
    }
}
