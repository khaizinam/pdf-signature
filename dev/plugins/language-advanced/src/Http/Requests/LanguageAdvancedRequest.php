<?php

namespace Dev\LanguageAdvanced\Http\Requests;

use Dev\Support\Http\Requests\Request;

class LanguageAdvancedRequest extends Request
{
    public function rules(): array
    {
        return [
            'model' => 'required|string|max:255',
        ];
    }
}
