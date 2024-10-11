<?php

namespace Dev\Api\Forms\Settings;

use Dev\Api\Facades\ApiHelper;
use Dev\Api\Http\Requests\ApiSettingRequest;
use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Setting\Forms\SettingForm;

class ApiSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setValidatorClass(ApiSettingRequest::class)
            ->setSectionTitle(trans('libs/api::api.setting_title'))
            ->setSectionDescription(trans('libs/api::api.setting_description'))
            ->contentOnly()
            ->add(
                'api_enabled',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label(trans('libs/api::api.api_enabled'))
                    ->value(ApiHelper::enabled())
                    ->toArray()
            );
    }
}
