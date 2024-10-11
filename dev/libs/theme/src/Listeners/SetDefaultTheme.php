<?php

namespace Dev\Theme\Listeners;

use Dev\Setting\Facades\Setting;
use Dev\Theme\Facades\Theme;

class SetDefaultTheme
{
    public function handle(): void
    {
        Setting::forceSet('theme', Theme::getThemeName())->set('show_admin_bar', 1)->save();
    }
}
