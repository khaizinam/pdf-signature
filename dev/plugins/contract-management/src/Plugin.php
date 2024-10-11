<?php

namespace Dev\ContractManagement;

use Illuminate\Support\Facades\Schema;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Contract Managements');
        Schema::dropIfExists('Contract Managements_translations');
    }
}
