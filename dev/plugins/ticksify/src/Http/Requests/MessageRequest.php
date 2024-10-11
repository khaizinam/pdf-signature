<?php

namespace Dev\Ticksify\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class MessageRequest extends Request
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:10000'],
            'status' => [Rule::in(BaseStatusEnum::values())],
        ];
    }
}
