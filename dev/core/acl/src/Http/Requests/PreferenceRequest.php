<?php

namespace Dev\ACL\Http\Requests;

use Dev\Base\Supports\Language;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PreferenceRequest extends Request
{
    public function rules(): array
    {
        return [
            'locale' => ['sometimes', Rule::in(array_keys(Language::getAvailableLocales()))],
            'locale_direction' => ['required', 'string', 'in:ltr,rtl'],
            'theme_mode' => ['required', 'string', 'in:light,dark'],
        ];
    }
}
