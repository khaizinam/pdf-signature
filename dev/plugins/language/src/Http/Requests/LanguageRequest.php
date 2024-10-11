<?php

namespace Dev\Language\Http\Requests;

use Dev\Base\Supports\Language;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class LanguageRequest extends Request
{
    public function rules(): array
    {
        return [
            'lang_name' => 'required|string|max:30|min:2',
            'lang_code' => [
                'required',
                'string',
                Rule::in(Language::getLanguageCodes()),
            ],
            'lang_locale' => [
                'required',
                'string',
                Rule::in(Language::getLocaleKeys()),
            ],
            'lang_flag' => 'required|string',
            'lang_is_rtl' => 'required|boolean',
            'lang_order' => 'required|numeric',
        ];
    }
}
