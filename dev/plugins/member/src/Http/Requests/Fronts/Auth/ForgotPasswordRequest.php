<?php

namespace Dev\Member\Http\Requests\Fronts\Auth;

use Dev\Base\Rules\EmailRule;
use Dev\Support\Http\Requests\Request;

class ForgotPasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => ['required', new EmailRule()],
        ];
    }
}
