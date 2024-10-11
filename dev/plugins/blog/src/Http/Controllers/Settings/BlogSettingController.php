<?php

namespace Dev\Blog\Http\Controllers\Settings;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Blog\Forms\Settings\BlogSettingForm;
use Dev\Blog\Http\Requests\Settings\BlogSettingRequest;
use Dev\Setting\Http\Controllers\SettingController;

class BlogSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/blog::base.settings.title'));

        return BlogSettingForm::create()->renderForm();
    }

    public function update(BlogSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate($request->validated());
    }
}
