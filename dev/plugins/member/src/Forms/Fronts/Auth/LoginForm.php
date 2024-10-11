<?php

namespace Dev\Member\Forms\Fronts\Auth;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Facades\Html;
use Dev\Base\Forms\FieldOptions\CheckboxFieldOption;
use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\Fields\EmailField;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Base\Forms\Fields\PasswordField;
use Dev\Member\Forms\Fronts\Auth\FieldOptions\EmailFieldOption;
use Dev\Member\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Dev\Member\Http\Requests\Fronts\Auth\LoginRequest;
use Dev\Member\Models\Member;

class LoginForm extends AuthForm
{
    public static function formTitle(): string
    {
        return trans('plugins/member::member.form.login_title');
    }

    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('public.member.login.post'))
            ->setValidatorClass(LoginRequest::class)
            ->icon('ti ti-lock')
            ->heading(__('Login to your account'))
            ->description(__('Your personal data will be used to support your experience throughout this website, to manage access to your account.'))
            ->when(
                theme_option('login_background'),
                fn (AuthForm $form, string $background) => $form->banner($background)
            )
            ->add(
                'email',
                EmailField::class,
                EmailFieldOption::make()
                    ->label(__('Email'))
                    ->placeholder(__('Email address'))
                    ->icon('ti ti-mail')
                    ->toArray()
            )
            ->add(
                'password',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(__('Password'))
                    ->placeholder(__('Password'))
                    ->icon('ti ti-lock')
                    ->toArray()
            )
            ->add('openRow', HtmlField::class, [
                'html' => '<div class="row g-0 mb-3">',
            ])
            ->add(
                'remember',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(__('Remember me'))
                    ->wrapperAttributes(['class' => 'col-6'])
                    ->toArray()
            )
            ->add(
                'forgot_password',
                HtmlField::class,
                [
                    'html' => Html::link(route('public.member.password.request'), __('Forgot password?'), attributes: ['class' => 'text-decoration-underline']),
                    'wrapper' => [
                        'class' => 'col-6 text-end',
                    ],
                ]
            )
            ->add('closeRow', HtmlField::class, [
                'html' => '</div>',
            ])
            ->submitButton(sprintf('%s %s', __('Login'), BaseHelper::renderIcon('ti ti-arrow-narrow-right', null, ['class' => 'ms-1'])))
            ->add(
                'register',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->view('plugins/member::includes.register-link')
                    ->toArray()
            )
            ->add('filters', HtmlField::class, [
                'html' => apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, Member::class),
            ]);
    }
}
