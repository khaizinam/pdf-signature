<?php

namespace Dev\CustomField\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateFieldGroupRequest extends Request
{
    public function rules(): array
    {
        return [
            'order' => ['required', 'integer', 'min:0', 'max:127'],
            'rules' => ['json', 'required'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', Rule::in(BaseStatusEnum::values())],
        ];
    }
}
