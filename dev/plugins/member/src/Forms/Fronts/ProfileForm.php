<?php

namespace Dev\Member\Forms\Fronts;

use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Member\Forms\MemberForm;
use Dev\Member\Http\Requests\SettingRequest;

class ProfileForm extends MemberForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setValidatorClass(SettingRequest::class)
            ->setUrl(route('public.member.post.settings'))
            ->setFormOption('template', 'core/base::forms.form-content-only')
            ->columns()
            ->modify('email', TextField::class, [
                'required' => false,
                'attr' => [
                    'disabled' => true,
                ],
            ], true)
            ->addBefore('email', 'openRow', 'html', [
                'html' => '<div>',
            ])
            ->addAfter('email', 'email_status', 'html', [
                'html' => view(
                    'plugins/member::themes.dashboard.settings.partials.email-status',
                    ['user' => $this->getModel()]
                )->render(),
            ])
            ->addAfter('email_status', 'closeRow', 'html', [
                'html' => '</div>',
            ])
            ->addAfter('dob', 'gender', SelectField::class, [
                'label' => trans('plugins/member::dashboard.gender'),
                'choices' => [
                    'male' => trans('plugins/member::dashboard.gender_male'),
                    'female' => trans('plugins/member::dashboard.gender_female'),
                    'other' => trans('plugins/member::dashboard.gender_other'),
                ],
            ])
            ->remove(
                [
                    'is_change_password',
                    'openRow1',
                    'password',
                    'password_confirmation',
                    'closeRow1',
                    'avatar_image',
                    'status',
                ]
            )
            ->add(
                'submit',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->view('plugins/member::includes.submit', ['label' => trans('plugins/member::dashboard.save')])
                    ->toArray()
            );
    }
}
