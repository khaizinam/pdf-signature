<?php

namespace Dev\Projects\Http\Controllers\Settings;

use Dev\Base\Forms\FormBuilder;
use Dev\Projects\Forms\Settings\ProjectsForm;
use Dev\Projects\Http\Requests\Settings\ProjectsRequest;
use Dev\Setting\Http\Controllers\SettingController;

class ProjectsController extends SettingController
{
    public function edit(FormBuilder $formBuilder)
    {
        $this->pageTitle('Page title');

        return $formBuilder->create(ProjectsForm::class)->renderForm();
    }

    public function update(ProjectsRequest $request)
    {
        return $this->performUpdate($request->validated());
    }
}
