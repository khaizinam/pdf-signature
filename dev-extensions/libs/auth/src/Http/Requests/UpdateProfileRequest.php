<?php

namespace Dev\Auth\Http\Requests;

use Dev\Auth\Facades\AuthHelper;
use Dev\Support\Http\Requests\Request;

class UpdateProfileRequest extends Request
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:120|min:2',
            'last_name' => 'required|max:120|min:2',
            'phone' => 'required|max:15|min:8',
            'dob' => 'required|max:15|min:8',
            'gender' => 'nullable',
            'description' => 'nullable',
        ];
    }
}
