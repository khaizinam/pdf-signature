<?php

namespace Dev\PluginManager\Http\Requests;

use Dev\Support\Http\Requests\Request;

class UploadFilePluginRequest extends Request
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:zip', 'max:2048'],
        ];
    }
}
