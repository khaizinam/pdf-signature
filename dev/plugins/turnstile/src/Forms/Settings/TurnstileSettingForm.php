<?php

namespace Dev\Turnstile\Forms\Settings;

use Dev\Base\Forms\FieldOptions\AlertFieldOption;
use Dev\Base\Forms\FieldOptions\LabelFieldOption;
use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\AlertField;
use Dev\Base\Forms\Fields\LabelField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Forms\FormCollapse;
use Dev\Setting\Forms\SettingForm;
use Dev\Turnstile\Facades\Turnstile;
use Dev\Turnstile\Http\Requests\Settings\TurnstileSettingRequest;

class TurnstileSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('turnstile.settings'))
            ->setSectionTitle(trans('plugins/turnstile::turnstile.settings.title'))
            ->setSectionDescription(trans('plugins/turnstile::turnstile.settings.description'))
            ->setValidatorClass(TurnstileSettingRequest::class)
            ->add(
                'description',
                AlertField::class,
                AlertFieldOption::make()
                    ->content(str_replace(
                        '<a>',
                        '<a href="https://dash.cloudflare.com/sign-up?to=/:account/turnstile" target="_blank">',
                        trans('plugins/turnstile::turnstile.settings.help_text')
                    ))
                    ->toArray()
            )
            ->add(
                Turnstile::getSettingKey('site_key'),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/turnstile::turnstile.settings.site_key'))
                    ->value(Turnstile::getSetting('site_key'))
                    ->toArray()
            )
            ->add(
                Turnstile::getSettingKey('secret_key'),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/turnstile::turnstile.settings.secret_key'))
                    ->value(Turnstile::getSetting('secret_key'))
                    ->toArray()
            )
            ->addCollapsible(
                FormCollapse::make('settings')
                    ->targetField(
                        Turnstile::getSettingKey('enabled'),
                        OnOffField::class,
                        OnOffFieldOption::make()
                            ->label(trans('plugins/turnstile::turnstile.settings.enable'))
                            ->value(Turnstile::isEnabled())
                            ->toArray(),
                    )
                    ->isOpened(Turnstile::isEnabled())
                    ->fieldset(function (FormAbstract $form) {
                        $form->add(
                            Turnstile::getSettingKey('enable_form_label'),
                            LabelField::class,
                            LabelFieldOption::make()
                                ->label(trans('plugins/turnstile::turnstile.settings.enable_form'))
                                ->toArray()
                        );
                        foreach (Turnstile::getForms() as $form => $title) {
                            $this->add(
                                Turnstile::getFormSettingKey($form),
                                OnOffField::class,
                                OnOffFieldOption::make()
                                    ->label($title)
                                    ->value(Turnstile::isEnabledForForm($form))
                                    ->toArray()
                            );
                        }
                    })
            );
    }
}
