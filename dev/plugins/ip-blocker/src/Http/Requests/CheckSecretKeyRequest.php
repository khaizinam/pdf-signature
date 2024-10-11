<?php

namespace ArchiElite\IpBlocker\Http\Requests;

use Dev\Support\Http\Requests\Request;

class CheckSecretKeyRequest extends Request
{
    public function rules(): array
    {
        return [
            'secret_key' => ['required', 'string', 'size:14'],
        ];
    }
}
