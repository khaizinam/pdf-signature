<?php

namespace Dev\Setting\Http\Requests;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;

class EmailTemplateChangeStatusRequest extends Request
{
    public function rules(): array
    {
        return [
            'key' => ['required', 'string'],
            'value' => [new OnOffRule()],
        ];
    }
}
