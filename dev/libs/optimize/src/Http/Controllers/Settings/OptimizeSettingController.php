<?php

namespace Dev\Optimize\Http\Controllers\Settings;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Optimize\Forms\Settings\OptimizeSettingForm;
use Dev\Optimize\Http\Requests\OptimizeSettingRequest;
use Dev\Setting\Http\Controllers\SettingController;

class OptimizeSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('libs/optimize::optimize.settings.title'));

        return OptimizeSettingForm::create()->renderForm();
    }

    public function update(OptimizeSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate($request->validated());
    }
}
