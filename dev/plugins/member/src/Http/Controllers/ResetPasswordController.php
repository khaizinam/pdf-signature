<?php

namespace Dev\Member\Http\Controllers;

use Dev\ACL\Traits\ResetsPasswords;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Member\Forms\Fronts\Auth\ResetPasswordForm;
use Dev\Member\Http\Requests\Fronts\Auth\ResetPasswordRequest;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends BaseController
{
    use ResetsPasswords {
        ResetsPasswords::reset as parentReset;
    }

    public string $redirectTo = '/';

    public function __construct()
    {
        $this->redirectTo = route('public.member.dashboard');
    }

    public function showResetForm(Request $request, $token = null)
    {
        SeoHelper::setTitle(__('Reset Password'));

        return Theme::scope(
            'member.auth.passwords.reset',
            [
                'token' => $token,
                'email' => $request->input('email'),
                'form' => ResetPasswordForm::create(),
            ],
            'plugins/member::themes.auth.passwords.reset'
        )->render();
    }

    public function reset(ResetPasswordRequest $request)
    {
        return $this->parentReset($request);
    }

    public function broker()
    {
        return Password::broker('members');
    }

    protected function guard()
    {
        return auth('member');
    }
}
