<?php

namespace Dev\SanctumToken\Http\Requests;

use Dev\Support\Http\Requests\Request;

class StoreSanctumTokenRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'abilities' => ['nullable', 'array'],
        ];
    }
}
