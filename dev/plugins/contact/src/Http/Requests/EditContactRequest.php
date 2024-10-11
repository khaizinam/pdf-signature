<?php

namespace Dev\Contact\Http\Requests;

use Dev\Contact\Enums\ContactStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class EditContactRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => Rule::in(ContactStatusEnum::values()),
        ];
    }
}
