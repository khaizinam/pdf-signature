<?php

namespace Dev\Member\Http\Controllers;

use Dev\ACL\Traits\SendsPasswordResetEmails;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Member\Forms\Fronts\Auth\ForgotPasswordForm;
use Dev\Member\Http\Requests\Fronts\Auth\ForgotPasswordRequest;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Theme\Facades\Theme;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends BaseController
{
    use SendsPasswordResetEmails {
        SendsPasswordResetEmails::sendResetLinkEmail as parentSendResetLinkEmail;
    }

    public function showLinkRequestForm()
    {
        SeoHelper::setTitle(trans('plugins/member::member.forgot_password'));

        return Theme::scope(
            'member.auth.passwords.email',
            ['form' => ForgotPasswordForm::create()],
            'plugins/member::themes.auth.passwords.email'
        )->render();
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        return $this->parentSendResetLinkEmail($request);
    }

    public function broker()
    {
        return Password::broker('members');
    }
}
