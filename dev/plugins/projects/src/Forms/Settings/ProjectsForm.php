<?php

namespace Dev\Projects\Forms\Settings;

use Dev\Projects\Http\Requests\Settings\ProjectsRequest;
use Dev\Setting\Forms\SettingForm;

class ProjectsForm extends SettingForm
{
    public function buildForm(): void
    {
        parent::buildForm();

        $this
            ->setSectionTitle('Setting title')
            ->setSectionDescription('Setting description')
            ->setValidatorClass(ProjectsRequest::class);
    }
}
