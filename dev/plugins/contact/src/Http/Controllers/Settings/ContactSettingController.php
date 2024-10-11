<?php

namespace Dev\Contact\Http\Controllers\Settings;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Contact\Forms\Settings\ContactSettingForm;
use Dev\Contact\Http\Requests\Settings\ContactSettingRequest;
use Dev\Setting\Http\Controllers\SettingController;
use Illuminate\Support\Arr;

class ContactSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/contact::contact.settings.title'));

        return ContactSettingForm::create()->renderForm();
    }

    public function update(ContactSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate(Arr::except($request->validated(), [
            'receiver_emails_for_validation',
            'blacklist_keywords_for_validation',
        ]));
    }
}
