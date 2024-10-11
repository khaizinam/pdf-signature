<?php

namespace Dev\Contact\Forms\Settings;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FieldOptions\TextareaFieldOption;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Contact\Http\Requests\Settings\ContactSettingRequest;
use Dev\Setting\Forms\SettingForm;

class ContactSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        Assets::addStylesDirectly('vendor/core/core/base/libraries/tagify/tagify.css')
            ->addScriptsDirectly([
                'vendor/core/core/base/libraries/tagify/tagify.js',
                'vendor/core/core/base/js/tags.js',
            ]);

        $this
            ->setSectionTitle(trans('plugins/contact::contact.settings.title'))
            ->setSectionDescription(trans('plugins/contact::contact.settings.description'))
            ->setValidatorClass(ContactSettingRequest::class)
            ->add(
                'blacklist_keywords',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->addAttribute('class', 'tags form-control')
                    ->addAttribute('data-counter', '250')
                    ->value(setting('blacklist_keywords'))
                    ->label(trans('plugins/contact::contact.settings.blacklist_keywords'))
                    ->placeholder(trans('plugins/contact::contact.settings.blacklist_keywords_placeholder'))
                    ->helperText(trans('plugins/contact::contact.settings.blacklist_keywords_helper'))
                    ->toArray()
            )
            ->add(
                'receiver_emails',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->addAttribute('class', 'tags form-control')
                    ->value(setting('receiver_emails'))
                    ->label(trans('plugins/contact::contact.settings.receiver_emails'))
                    ->placeholder(trans('plugins/contact::contact.settings.receiver_emails_placeholder'))
                    ->helperText(trans('plugins/contact::contact.settings.receiver_emails_helper'))
                    ->toArray()
            );
    }
}
