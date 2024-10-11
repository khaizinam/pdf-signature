<?php

namespace Dev\Base\Http\Requests;

use Dev\Support\Http\Requests\Request;

class SelectSearchAjaxRequest extends Request
{
    public function rules(): array
    {
        return [
            'search' => ['required', 'string'],
            'page' => ['required', 'integer'],
        ];
    }
}
