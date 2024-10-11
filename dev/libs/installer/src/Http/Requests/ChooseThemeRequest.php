<?php

namespace Dev\Installer\Http\Requests;

use Dev\Support\Http\Requests\Request;
use Dev\Theme\Facades\Manager;
use Illuminate\Validation\Rule;

class ChooseThemeRequest extends Request
{
    public function rules(): array
    {
        return [
            'theme' => ['required', 'string', Rule::in(array_keys(Manager::getThemes()))],
        ];
    }
}
