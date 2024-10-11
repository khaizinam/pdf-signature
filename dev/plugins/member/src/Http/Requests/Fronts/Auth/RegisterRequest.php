<?php

namespace Dev\Member\Http\Requests\Fronts\Auth;

use Dev\Base\Rules\EmailRule;
use Dev\Support\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:120', 'min:2'],
            'last_name' => ['required', 'string', 'max:120', 'min:2'],
            'email' => ['required', 'max:60', 'min:6', new EmailRule(), 'unique:members'],
            'password' => ['required', 'min:6', 'confirmed'],
            'agree_terms_and_policy' => ['sometimes', 'accepted:1'],
        ];
    }
}
