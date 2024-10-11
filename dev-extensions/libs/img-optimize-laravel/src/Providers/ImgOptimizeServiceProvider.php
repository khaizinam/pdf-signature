<?php

namespace Dev\ImgOptimize\Providers;

use Dev\Base\Facades\MacroableModels;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

use Dev\Base\Supports\Helper;
use Dev\Kernel\Traits\LoadAndPublishDataTrait;

class ImgOptimizeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);

        $this->setNamespace('libs/img-optimize-laravel')
            ->loadMigrations();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }
}
