<?php

namespace Dev\ThemeGenerator\Providers;

use Dev\Base\Supports\ServiceProvider;

class ThemeGeneratorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->register(CommandServiceProvider::class);
    }
}
