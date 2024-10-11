<?php

namespace Dev\Member\Http\Requests\Fronts\Auth;

use Dev\Base\Rules\EmailRule;
use Dev\Support\Http\Requests\Request;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', new EmailRule()],
            'password' => ['required', 'string'],
        ];
    }
}
