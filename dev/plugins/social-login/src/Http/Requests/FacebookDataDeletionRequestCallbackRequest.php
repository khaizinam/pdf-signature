<?php

namespace Dev\SocialLogin\Http\Requests;

use Dev\Support\Http\Requests\Request;

class FacebookDataDeletionRequestCallbackRequest extends Request
{
    public function rules(): array
    {
        return [
            'signed_request' => ['required', 'string'],
        ];
    }
}
