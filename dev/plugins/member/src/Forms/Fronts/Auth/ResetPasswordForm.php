<?php

namespace Dev\Member\Forms\Fronts\Auth;

use Dev\Base\Forms\Fields\EmailField;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\PasswordField;
use Dev\Member\Forms\Fronts\Auth\FieldOptions\EmailFieldOption;
use Dev\Member\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Dev\Member\Http\Requests\Fronts\Auth\ResetPasswordRequest;

class ResetPasswordForm extends AuthForm
{
    public static function formTitle(): string
    {
        return trans('plugins/member::member.form.reset_password_title');
    }

    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('public.member.password.update'))
            ->icon('ti ti-lock')
            ->setValidatorClass(ResetPasswordRequest::class)
            ->heading(__('Reset Password'))
            ->add(
                'token',
                'hidden',
                TextFieldOption::make()
                    ->value($this->request->route('token'))
                    ->toArray()
            )
            ->add(
                'email',
                EmailField::class,
                EmailFieldOption::make()
                    ->label(__('Email address'))
                    ->value($this->request->email)
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
            ->add(
                'password_confirmation',
                PasswordField::class,
                TextFieldOption::make()
                    ->label(__('Password confirmation'))
                    ->placeholder(__('Password confirmation'))
                    ->icon('ti ti-lock')
                    ->toArray()
            )
            ->submitButton(__('Reset Password'))
            ->add('back_to_login', HtmlField::class, [
                'html' => sprintf(
                    '<div class="mt-3 text-center"><a href="%s" class="text-decoration-underline">%s</a></div>',
                    route('public.member.login'),
                    __('Back to login page')
                ),
            ]);
    }
}
