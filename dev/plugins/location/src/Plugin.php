<?php

namespace Dev\Location;

use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('countries_translations');
        Schema::dropIfExists('states_translations');
        Schema::dropIfExists('cities_translations');
    }
}
