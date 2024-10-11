<?php

namespace Dev\EditLock\Providers;

use Illuminate\Support\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\EditLock\Facades\EditLockFacade;
use Illuminate\Foundation\AliasLoader;

class EditLockServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->setNamespace('plugins/edit-lock');

        AliasLoader::getInstance()->alias('EditLock', EditLockFacade::class);
    }

    public function boot(): void
    {
        $this
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews();

        $this->app->register(EventServiceProvider::class);
        $this->app->register(HookServiceProvider::class);
    }
}
