<?php

namespace Dev\ACL\Http\Requests;

use Dev\Support\Http\Requests\Request;

class PreferencePatchRequest extends Request
{
    public function rules(): array
    {
        return [
            'minimal_sidebar' => ['sometimes', 'required', 'in:yes,no'],
        ];
    }
}
