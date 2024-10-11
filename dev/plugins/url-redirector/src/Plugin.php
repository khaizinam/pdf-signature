<?php

namespace ArchiElite\UrlRedirector;

use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function removed(): void
    {
        Schema::dropIfExists('url_redirector');
    }
}
