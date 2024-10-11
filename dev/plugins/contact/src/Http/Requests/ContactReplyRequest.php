<?php

namespace Dev\Contact\Http\Requests;

use Dev\Support\Http\Requests\Request;

class ContactReplyRequest extends Request
{
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:10000'],
        ];
    }
}
