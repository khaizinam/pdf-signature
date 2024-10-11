<?php

namespace Dev\Translation\Http\Requests;

use Dev\Base\Supports\Language;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class LocaleRequest extends Request
{
    public function rules(): array
    {
        return [
            'locale' => ['required', Rule::in(Language::getLocaleKeys())],
        ];
    }
}
