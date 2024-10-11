<?php

namespace Dev\Member\Forms\Settings;

use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Member\Http\Requests\Settings\MemberSettingRequest;
use Dev\Setting\Forms\SettingForm;

class MemberSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setSectionTitle(trans('plugins/member::settings.title'))
            ->setSectionDescription(trans('plugins/member::settings.description'))
            ->setValidatorClass(MemberSettingRequest::class)
            ->add(
                'verify_account_email',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/member::settings.verify_account_email'))
                    ->value(setting('verify_account_email', false))
                    ->helperText(trans('plugins/member::settings.verify_account_email_description'))
                    ->toArray()
            );
    }
}
