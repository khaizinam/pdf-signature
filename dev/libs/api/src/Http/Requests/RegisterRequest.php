<?php

namespace Dev\Api\Http\Requests;

use Dev\Api\Facades\ApiHelper;
use Dev\Support\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:120', 'min:2'],
            'last_name' => ['required', 'string', 'max:120', 'min:2'],
            'email' => 'required|max:60|min:6|email|unique:' . ApiHelper::getTable(),
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'first_name' => [
                'example' => 'e.g: John',
            ],
            'last_name' => [
                'example' => 'e.g: Smith',
            ],
            'email' => [
                'example' => 'e.g: abc@example.com',
            ],
        ];
    }
}
