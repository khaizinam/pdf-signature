<?php

namespace Dev\SocialLogin\Zalo;

use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Dev\Setting\Facades\Setting;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Setting::delete([
            'social_login_zalo_enable',
            'social_login_zalo_app_id',
            'social_login_zalo_app_secret',
        ]);
    }
}
