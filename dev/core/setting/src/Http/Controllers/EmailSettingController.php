<?php

namespace Dev\Setting\Http\Controllers;

use Dev\Base\Facades\Assets;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Setting\Forms\EmailSettingForm;
use Dev\Setting\Http\Requests\EmailSettingRequest;

class EmailSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('core/setting::setting.panel.email'));

        Assets::addScriptsDirectly('vendor/core/core/setting/js/email-template.js');

        $form = null;

        if (config('core.base.general.enable_email_configuration_from_admin_panel', true)) {
            $form = EmailSettingForm::create();
        }

        return view('core/setting::email', compact('form'));
    }

    public function update(EmailSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate($request->validated());
    }
}
