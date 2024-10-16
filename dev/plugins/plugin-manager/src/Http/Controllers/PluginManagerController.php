<?php

namespace Dev\PluginManager\Http\Controllers;

use Dev\Base\Facades\Assets;
use Dev\Base\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class PluginManagerController extends BaseController
{
    public function __invoke(): View
    {
        $this->pageTitle(__('Plugin Manager'));

        Assets::usingVueJS()->addScriptsDirectly('vendor/core/plugins/plugin-manager/js/plugin-manager.js');

        $lastCheckUpdate = Carbon::parse(setting('plugin_manager.last_update_check'))->diffForHumans();

        return view('plugins/plugin-manager::index', compact('lastCheckUpdate'));
    }
}
