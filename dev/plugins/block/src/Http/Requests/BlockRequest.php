<?php

namespace Dev\Block\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BlockRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'alias' => ['required', 'string', 'max:250'],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
