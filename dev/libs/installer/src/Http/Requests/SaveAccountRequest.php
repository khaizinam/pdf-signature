<?php

namespace Dev\Installer\Http\Requests;

use Dev\ACL\Http\Requests\CreateUserRequest;

class SaveAccountRequest extends CreateUserRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['username'] = 'required|alpha_dash|min:4|max:30';

        return $rules;
    }
}
