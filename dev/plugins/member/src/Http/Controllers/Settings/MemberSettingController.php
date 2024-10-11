<?php

namespace Dev\Member\Http\Controllers\Settings;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Member\Forms\Settings\MemberSettingForm;
use Dev\Member\Http\Requests\Settings\MemberSettingRequest;
use Dev\Setting\Http\Controllers\SettingController;

class MemberSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/member::settings.title'));

        return MemberSettingForm::create()->renderForm();
    }

    public function update(MemberSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate($request->validated());
    }
}
