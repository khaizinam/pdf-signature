<?php

namespace Dev\Api\Http\Requests;

use Dev\Support\Http\Requests\Request;

class ResendEmailVerificationRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'email' => [
                'example' => 'e.g: abc@example.com',
            ],
        ];
    }
}
