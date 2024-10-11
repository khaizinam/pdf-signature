<?php

namespace Dev\Auth\Http\Controllers;

use Dev\Auth\Http\Requests\AuthSettingRequest;
use Dev\Base\Facades\Assets;
use Dev\Base\Facades\PageTitle;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function settings()
    {
        PageTitle::setTitle(trans('libs/auth::auth.settings'));

        Assets::addScriptsDirectly('vendor/core/core/setting/js/setting.js');
        Assets::addStylesDirectly('vendor/core/core/setting/css/setting.css');

        if (version_compare('7.0.0', get_core_version(), '>')) {
            return view('libs/auth::settings-v6');
        }

        return view('libs/auth::settings');
    }

    public function storeSettings(AuthSettingRequest $request, BaseHttpResponse $response)
    {
        $this->saveSettings($request->except([
            '_token',
        ]));

        return $response
            ->setPreviousUrl(route('auth.settings'))
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
