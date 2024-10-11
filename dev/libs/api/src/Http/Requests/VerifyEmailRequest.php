<?php

namespace Dev\Api\Http\Requests;

use Dev\Support\Http\Requests\Request;

class VerifyEmailRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'token' => 'required|string',
        ];
    }
}
