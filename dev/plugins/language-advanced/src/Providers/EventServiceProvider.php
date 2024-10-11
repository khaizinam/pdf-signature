<?php

namespace Dev\LanguageAdvanced\Providers;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\LanguageAdvanced\Listeners\AddDefaultTranslations;
use Dev\LanguageAdvanced\Listeners\AddRefLangToAdminBar;
use Dev\LanguageAdvanced\Listeners\ClearCacheAfterUpdateData;
use Dev\LanguageAdvanced\Listeners\PriorityLanguageAdvancedPluginListener;
use Dev\LanguageAdvanced\Listeners\UpdatePermalinkSettingsForEachLanguage;
use Dev\PluginManagement\Events\ActivatedPluginEvent;
use Dev\Slug\Events\UpdatedPermalinkSettings;
use Dev\Theme\Events\RenderingAdminBar;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreatedContentEvent::class => [
            AddDefaultTranslations::class,
        ],
        UpdatedContentEvent::class => [
            ClearCacheAfterUpdateData::class,
        ],
        ActivatedPluginEvent::class => [
            PriorityLanguageAdvancedPluginListener::class,
        ],
        UpdatedPermalinkSettings::class => [
            UpdatePermalinkSettingsForEachLanguage::class,
        ],
        RenderingAdminBar::class => [
            AddRefLangToAdminBar::class,
        ],
    ];
}
