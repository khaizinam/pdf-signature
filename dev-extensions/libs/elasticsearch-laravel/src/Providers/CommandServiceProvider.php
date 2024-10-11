<?php

namespace Dev\ElasticsearchLaravel\Providers;

use Illuminate\Support\ServiceProvider;

use Dev\ElasticsearchLaravel\Commands\ElasticSearchMakeIndex;
use Dev\ElasticsearchLaravel\Commands\ElasticSearchRemoveIndex;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // if (function_exists('is_plugin_active') && is_plugin_active('your-plugin-name')) {}
            $this->commands([
                ElasticSearchMakeIndex::class
            ]);
        }
    }
}
