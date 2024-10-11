<?php

namespace Dev\Optimize\Forms\Settings;

use Dev\Optimize\Http\Requests\OptimizeSettingRequest;
use Dev\Setting\Forms\SettingForm;

class OptimizeSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setSectionTitle(trans('libs/optimize::optimize.settings.title'))
            ->setSectionDescription(trans('libs/optimize::optimize.settings.description'))
            ->setValidatorClass(OptimizeSettingRequest::class)
            ->add('optimize_fields', 'html', [
                'html' => view('libs/optimize::partials.settings.forms.optimize-fields')->render(),
            ]);
    }
}
