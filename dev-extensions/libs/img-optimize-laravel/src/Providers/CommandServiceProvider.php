<?php

namespace Dev\ImgOptimize\Providers;

use Dev\ImgOptimize\Commands\WebPCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // if (function_exists('is_plugin_active') && is_plugin_active('your-plugin-name')) {}
            $this->commands([
                WebPCommand::class
            ]);
        }
    }
}
