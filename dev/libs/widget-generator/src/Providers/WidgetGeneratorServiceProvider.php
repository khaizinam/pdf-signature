<?php

namespace Dev\WidgetGenerator\Providers;

use Dev\Base\Supports\ServiceProvider;

class WidgetGeneratorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->register(CommandServiceProvider::class);
    }
}
