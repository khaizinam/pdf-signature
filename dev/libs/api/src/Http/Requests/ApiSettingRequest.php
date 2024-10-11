<?php

namespace Dev\Api\Http\Requests;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;

class ApiSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'api_enabled' => [new OnOffRule()],
        ];
    }
}
