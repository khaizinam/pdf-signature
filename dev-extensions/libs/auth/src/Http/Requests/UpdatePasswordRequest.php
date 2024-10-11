<?php

namespace Dev\Auth\Http\Requests;

use Dev\Auth\Facades\AuthHelper;
use Dev\Support\Http\Requests\Request;

class UpdatePasswordRequest extends Request
{
    public function rules(): array
    {
        $user = request()->user();
        return [
            'password_current' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => 'required|min:6|max:60|confirmed'
        ];
    }
}
