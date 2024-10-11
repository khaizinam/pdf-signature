<?php

namespace Dev\Setting\Http\Controllers;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Setting\Forms\CacheSettingForm;
use Dev\Setting\Http\Requests\CacheSettingRequest;

class CacheSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('core/setting::setting.cache.title'));

        return CacheSettingForm::create()->renderForm();
    }

    public function update(CacheSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate($request->validated());
    }
}
