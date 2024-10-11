<?php

namespace Dev\MyStyle\Providers;

use Dev\Base\Supports\Helper;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\MyStyle\Facades\MyStyleHelperFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MyStyleServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
        AliasLoader::getInstance()->alias('MyStyleHelper', MyStyleHelperFacade::class);
    }

    public function boot()
    {
        $this->setNamespace('plugins/my-style')
            ->loadAndPublishConfigurations(['permissions', 'config'])
            ->loadAndPublishViews();

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
