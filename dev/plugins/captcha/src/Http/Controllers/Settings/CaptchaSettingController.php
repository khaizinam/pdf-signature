<?php

namespace Dev\Captcha\Http\Controllers\Settings;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Captcha\Forms\CaptchaSettingForm;
use Dev\Captcha\Http\Requests\Settings\CaptchaSettingRequest;
use Dev\Setting\Http\Controllers\SettingController;

class CaptchaSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/captcha::captcha.settings.title'));

        return CaptchaSettingForm::create()->renderForm();
    }

    public function update(CaptchaSettingRequest $request): BaseHttpResponse
    {
        $request->merge([
            'enable_math_captcha_for_contact_form' => $request->input('enable_math_captcha_dev_contact_forms_fronts_contact_form'),
            'enable_math_captcha_for_newsletter_form' => $request->input('enable_math_captcha_apps_newsletter_forms_fronts_newsletter_form'),
        ]);

        return $this->performUpdate($request->validated());
    }
}
