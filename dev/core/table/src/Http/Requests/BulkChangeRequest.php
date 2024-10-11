<?php

namespace Dev\Table\Http\Requests;

use Dev\Support\Http\Requests\Request;

class BulkChangeRequest extends Request
{
    public function rules(): array
    {
        return [
            'key' => ['required', 'string'],
            'class' => ['required', 'string'],
        ];
    }
}
