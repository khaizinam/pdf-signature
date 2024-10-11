<?php

namespace Dev\Language\Providers;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\Installer\Events\InstallerFinished;
use Dev\Language\Listeners\ActivatedPluginListener;
use Dev\Language\Listeners\AddHrefLangListener;
use Dev\Language\Listeners\CopyThemeOptions;
use Dev\Language\Listeners\CopyThemeWidgets;
use Dev\Language\Listeners\CreatedContentListener;
use Dev\Language\Listeners\CreateSelectedLanguageWhenInstallationFinished;
use Dev\Language\Listeners\DeletedContentListener;
use Dev\Language\Listeners\ThemeRemoveListener;
use Dev\Language\Listeners\UpdatedContentListener;
use Dev\PluginManagement\Events\ActivatedPluginEvent;
use Dev\Theme\Events\RenderingSingleEvent;
use Dev\Theme\Events\ThemeRemoveEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
            CopyThemeOptions::class,
            CopyThemeWidgets::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
        ThemeRemoveEvent::class => [
            ThemeRemoveListener::class,
        ],
        ActivatedPluginEvent::class => [
            ActivatedPluginListener::class,
        ],
        RenderingSingleEvent::class => [
            AddHrefLangListener::class,
        ],
        InstallerFinished::class => [
            CreateSelectedLanguageWhenInstallationFinished::class,
        ],
    ];
}
