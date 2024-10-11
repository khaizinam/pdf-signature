<?php

namespace Dev\AdvancedRole\Http\Controllers;

use Dev\AdvancedRole\Http\Requests\AdvancedRoleSettingRequest;
use Dev\Base\Facades\Assets;
use Dev\Base\Facades\PageTitle;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Routing\Controller;

class AdvancedRoleController extends Controller
{
    public function settings()
    {
        PageTitle::setTitle(trans('libs/advanced-role::advanced-role.settings'));

        Assets::addScriptsDirectly('vendor/core/core/setting/js/setting.js');
        Assets::addStylesDirectly('vendor/core/core/setting/css/setting.css');

        if (version_compare('7.0.0', get_core_version(), '>')) {
            return view('libs/advanced-role::settings-v6');
        }

        return view('libs/advanced-role::settings');
    }

    public function storeSettings(AdvancedRoleSettingRequest $request, BaseHttpResponse $response)
    {
        $this->saveSettings($request->except([
            '_token',
        ]));

        return $response
            ->setPreviousUrl(route('advanced-role.settings'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    protected function saveSettings(array $data)
    {
        foreach ($data as $settingKey => $settingValue) {
            if (is_array($settingValue)) {
                $settingValue = json_encode(array_filter($settingValue));
            }

            setting()->set($settingKey, (string)$settingValue);
        }

        setting()->save();
    }
}
