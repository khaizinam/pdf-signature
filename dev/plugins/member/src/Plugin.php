<?php

namespace Dev\Member;

use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Dev\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('member_activity_logs');
        Schema::dropIfExists('member_password_resets');
        Schema::dropIfExists('members');

        Setting::delete([
            'verify_account_email',
            'member_enable_recaptcha_in_register_page',
        ]);
    }
}
