<?php

namespace Dev\Auth\Http\Requests;

use Dev\Auth\Facades\AuthHelper;
use Dev\Support\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:120|min:2',
            'last_name' => 'required|string|max:120|min:2',
            'email' => 'required|max:60|min:6|email|unique:' . (new \Dev\AdvancedRole\Models\Member)->getTable(),
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
