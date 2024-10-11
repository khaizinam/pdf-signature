<?php

namespace Dev\Ticksify\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CategoryRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => [Rule::in(BaseStatusEnum::values())],
        ];
    }
}
