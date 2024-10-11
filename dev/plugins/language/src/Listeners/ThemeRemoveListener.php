<?php

namespace Dev\Language\Listeners;

use Dev\Base\Facades\BaseHelper;
use Dev\Language\Facades\Language;
use Dev\Setting\Models\Setting;
use Dev\Theme\Events\ThemeRemoveEvent;
use Dev\Theme\Facades\ThemeOption;
use Dev\Widget\Models\Widget;
use Exception;

class ThemeRemoveListener
{
    public function handle(ThemeRemoveEvent $event): void
    {
        try {
            $languages = Language::getActiveLanguage(['lang_code']);

            foreach ($languages as $language) {
                Widget::query()
                    ->where(['theme' => Widget::getThemeName($language->lang_code, theme: $event->theme)])
                    ->delete();

                Setting::query()
                    ->where(['key', 'LIKE', ThemeOption::getOptionKey('%', $language->lang_code)])
                    ->delete();
            }
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }
    }
}
