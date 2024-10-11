<?php

namespace Dev\Contact\Forms;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\NumberFieldOption;
use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Forms\MetaBox;
use Dev\Contact\Enums\CustomFieldType;
use Dev\Contact\Http\Requests\CustomFieldRequest;
use Dev\Contact\Models\CustomField;
use Dev\Language\Facades\Language;

class CustomFieldForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addScripts('jquery-ui')
            ->addScriptsDirectly('vendor/core/plugins/contact/js/custom-field.js');

        $this
            ->model(CustomField::class)
            ->formClass('custom-field-form')
            ->setValidatorClass(CustomFieldRequest::class)
            ->add(
                'type',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/contact::contact.custom_field.type'))
                    ->required()
                    ->choices(CustomFieldType::labels())
                    ->toArray()
            )
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->required()
                    ->toArray()
            )
            ->add(
                'placeholder',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/contact::contact.custom_field.placeholder'))
                    ->placeholder(trans('plugins/contact::contact.custom_field.placeholder'))
                    ->maxLength(120)
                    ->toArray()
            )
            ->add(
                'required',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/contact::contact.custom_field.required'))
                    ->toArray()
            )
            ->add(
                'order',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/contact::contact.custom_field.order'))
                    ->required()
                    ->defaultValue(999)
                    ->toArray()
            )
            ->when(is_plugin_active('language'), function (FormAbstract $form) {
                $isDefaultLanguage = ! defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')
                    || ! request()->input('ref_lang')
                    || request()->input('ref_lang') === Language::getDefaultLocaleCode();
                $customField = $form->getModel();
                $options = $customField->options->sortBy('order');

                $form->addMetaBox(
                    MetaBox::make('contact-custom-field-options')
                        ->hasTable()
                        ->attributes([
                            'class' => 'custom-field-options-box',
                            'style' => sprintf(
                                'display: %s;',
                                in_array(old('type', $customField), [CustomFieldType::DROPDOWN, CustomFieldType::RADIO]) ? 'block' : 'none;'
                            ),
                        ])
                        ->title(trans('plugins/contact::contact.custom_field.options'))
                        ->content(view(
                            'plugins/contact::partials.custom-field-options',
                            compact('options', 'isDefaultLanguage')
                        ))
                        ->footerContent($isDefaultLanguage ? view(
                            'plugins/contact::partials.custom-field-options-footer',
                            compact('isDefaultLanguage')
                        ) : null)
                );
            });
    }
}
