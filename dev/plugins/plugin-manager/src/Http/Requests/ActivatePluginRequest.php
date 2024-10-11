<?php

namespace Dev\PluginManager\Http\Requests;

use Dev\Support\Http\Requests\Request;

class ActivatePluginRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
