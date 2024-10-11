<?php

namespace Dev\VigReactions;

use Schema;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('vig_reactions');
        Schema::dropIfExists('vig_reaction_meta');
    }
}
