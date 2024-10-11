<?php

namespace Dev\Turnstile\Http\Controllers\Settings;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Setting\Http\Controllers\SettingController;
use Dev\Turnstile\Forms\Settings\TurnstileSettingForm;
use Dev\Turnstile\Http\Requests\Settings\TurnstileSettingRequest;

class TurnstileSettingController extends SettingController
{
    public function edit(): string
    {
        return TurnstileSettingForm::create()->renderForm();
    }

    public function update(TurnstileSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate($request->validated());
    }
}
