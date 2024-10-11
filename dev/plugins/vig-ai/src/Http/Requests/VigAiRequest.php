<?php

namespace VigStudio\VigAI\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class VigAiRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
