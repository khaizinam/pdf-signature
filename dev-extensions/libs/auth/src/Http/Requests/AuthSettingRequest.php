<?php

namespace Dev\Auth\Http\Requests;

use Dev\Support\Http\Requests\Request;

class AuthSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'auth_enabled' => 'nullable|in:0,1',
        ];
    }
}
