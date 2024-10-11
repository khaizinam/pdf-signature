<?php

namespace Dev\Setting\Http\Controllers;

use Dev\Base\Facades\AdminAppearance;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Setting\Forms\AdminAppearanceSettingForm;
use Dev\Setting\Http\Requests\AdminAppearanceRequest;
use Illuminate\Support\Arr;

class AdminAppearanceSettingController extends SettingController
{
    public function index()
    {
        $this->pageTitle(trans('core/setting::setting.admin_appearance.title'));

        return AdminAppearanceSettingForm::create()->renderForm();
    }

    public function update(AdminAppearanceRequest $request): BaseHttpResponse
    {
        $localeDirectionKey = AdminAppearance::getSettingKey('locale_direction');

        $data = Arr::except($request->validated(), [$localeDirectionKey]);

        $isDemoModeEnabled = BaseHelper::hasDemoModeEnabled();

        $adminLocalDirection = $request->input($localeDirectionKey);

        if ($adminLocalDirection != setting($localeDirectionKey)) {
            session()->put('admin_locale_direction', $adminLocalDirection);
        }

        if (! $isDemoModeEnabled) {
            $data[$localeDirectionKey] = $adminLocalDirection;
        }

        $this->forceSaveSettings =  ! $isDemoModeEnabled;

        return $this->performUpdate($data);
    }
}
