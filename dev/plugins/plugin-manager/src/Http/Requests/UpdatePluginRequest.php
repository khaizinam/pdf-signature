<?php

namespace Dev\PluginManager\Http\Requests;

use Dev\Support\Http\Requests\Request;

class UpdatePluginRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'file_path' => ['required', 'string'],
            'file_name' => ['required', 'string'],
        ];
    }
}
