<?php

namespace Dev\Member\Http\Requests;

use Dev\Base\Rules\EmailRule;
use Dev\Base\Rules\PhoneNumberRule;
use Dev\Support\Http\Requests\Request;

class MemberEditRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:120', 'min:2'],
            'last_name' => ['required', 'string', 'max:120', 'min:2'],
            'phone' => ['nullable', new PhoneNumberRule()],
            'email' => ['required', 'max:60', 'min:6', new EmailRule(), 'unique:members,email,' . $this->route('member.id')],
        ];

        if ($this->input('is_change_password') == 1) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $rules;
    }
}
