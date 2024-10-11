<?php

namespace Dev\PluginGenerator\Providers;

use Dev\Base\Supports\ServiceProvider;

class PluginGeneratorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->register(CommandServiceProvider::class);
    }
}
