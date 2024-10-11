<?php

namespace Dev\Comment;

use Dev\PluginManagement\Abstracts\PluginOperationAbstract;
use Dev\Setting\Models\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('fob_comments');

        Setting::query()
            ->where('key', 'like', 'fob_comment_%')
            ->delete();
    }
}
