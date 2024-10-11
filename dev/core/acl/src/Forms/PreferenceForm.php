<?php

namespace Dev\ACL\Forms;

use Dev\ACL\Http\Requests\PreferenceRequest;
use Dev\ACL\Models\User;
use Dev\Base\Facades\AdminAppearance;
use Dev\Base\Forms\FieldOptions\RadioFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\Fields\RadioField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Supports\Language;

class PreferenceForm extends FormAbstract
{
    public function setup(): void
    {
        $languages = collect(Language::getAvailableLocales())
            ->pluck('name', 'locale')
            ->map(fn ($item, $key) => $item . ' - ' . $key)
            ->all();

        /**
         * @var User $user
         */
        $user = $this->getModel();

        $adminAppearance = AdminAppearance::forUser($user);

        $this
            ->template('core/base::forms.form-no-wrap')
            ->setValidatorClass(PreferenceRequest::class)
            ->setMethod('PUT')
            ->when(count($languages) > 1, function (FormAbstract $form) use ($adminAppearance, $languages) {
                $form->add(
                    'locale',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(trans('core/setting::setting.admin_appearance.language'))
                        ->choices($languages)
                        ->selected($adminAppearance->getLocale())
                        ->toArray()
                );
            })
            ->add(
                'locale_direction',
                RadioField::class,
                RadioFieldOption::make()
                    ->label(trans('core/setting::setting.admin_appearance.form.admin_locale_direction'))
                    ->choices([
                        'ltr' => trans('core/setting::setting.locale_direction_ltr'),
                        'rtl' => trans('core/setting::setting.locale_direction_rtl'),
                    ])
                    ->selected($adminAppearance->getLocaleDirection())
                    ->toArray()
            )
            ->add(
                'theme_mode',
                RadioField::class,
                RadioFieldOption::make()
                    ->label(trans('core/setting::setting.admin_appearance.theme_mode'))
                    ->choices([
                        'light' => trans('core/setting::setting.admin_appearance.light'),
                        'dark' => trans('core/setting::setting.admin_appearance.dark'),
                    ])
                    ->selected($user->getMeta('theme_mode', 'light'))
                    ->toArray()
            )
            ->setActionButtons(view('core/acl::users.profile.actions')->render());
    }
}
