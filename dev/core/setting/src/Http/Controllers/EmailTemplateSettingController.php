<?php

namespace Dev\Setting\Http\Controllers;

use Dev\Base\Facades\Assets;
use Dev\Setting\Forms\EmailTemplateSettingForm;
use Dev\Setting\Http\Requests\EmailTemplateSettingRequest;
use Illuminate\Contracts\View\View;

class EmailTemplateSettingController extends SettingController
{
    public function index(): View
    {
        $this->pageTitle(trans('core/setting::setting.email.email_templates'));

        Assets::addScriptsDirectly('vendor/core/core/setting/js/email-template.js');

        $form = EmailTemplateSettingForm::create();

        return view('core/setting::email-templates', compact('form'));
    }

    public function update(EmailTemplateSettingRequest $request)
    {
        return $this->performUpdate(
            $request->validated()
        )->withUpdatedSuccessMessage();
    }
}
