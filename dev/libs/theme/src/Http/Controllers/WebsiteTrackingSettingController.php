<?php

namespace Dev\Theme\Http\Controllers;

use Dev\Setting\Http\Controllers\SettingController;
use Dev\Theme\Forms\Settings\WebsiteTrackingSettingForm;
use Dev\Theme\Http\Requests\WebsiteTrackingSettingRequest;

class WebsiteTrackingSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('libs/theme::theme.settings.website_tracking.title'));

        return WebsiteTrackingSettingForm::create()->renderForm();
    }

    public function update(WebsiteTrackingSettingRequest $request)
    {
        return $this->performUpdate(
            $request->validated()
        )->withUpdatedSuccessMessage();
    }
}
