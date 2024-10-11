<?php

namespace Dev\Comment\Http\Controllers\Settings;

use Dev\Setting\Http\Controllers\SettingController;
use Dev\Comment\Forms\Settings\CommentSettingForm;
use Dev\Comment\Http\Requests\Settings\CommentSettingRequest;

class CommentSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/comment::comment.settings.title'));

        return CommentSettingForm::create()->renderForm();
    }

    public function update(CommentSettingRequest $request)
    {
        return $this->performUpdate($request->validated());
    }
}
