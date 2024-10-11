<?php

namespace Dev\Translation\Http\Requests;

use Dev\Support\Http\Requests\Request;

class TranslationRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
        ];
    }
}
