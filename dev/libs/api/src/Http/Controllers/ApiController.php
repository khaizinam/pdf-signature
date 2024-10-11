<?php

namespace Dev\Api\Http\Controllers;

use Dev\Api\Forms\Settings\ApiSettingForm;
use Dev\Api\Http\Requests\ApiSettingRequest;
use Dev\Api\Tables\SanctumTokenTable;
use Dev\Setting\Http\Controllers\SettingController;

class ApiController extends SettingController
{
    public function edit(SanctumTokenTable $sanctumTokenTable)
    {
        $this->pageTitle(trans('libs/api::api.settings'));

        $this->breadcrumb()
            ->add(trans('core/setting::setting.title'), route('settings.index'))
            ->add(trans('libs/api::api.settings'));

        $form = ApiSettingForm::create();

        $sanctumTokenTable->setAjaxUrl(route('api.sanctum-token.index'));

        return view('libs/api::settings', compact('form', 'sanctumTokenTable'));
    }

    public function update(ApiSettingRequest $request)
    {
        return $this->performUpdate($request->validated());
    }
}
