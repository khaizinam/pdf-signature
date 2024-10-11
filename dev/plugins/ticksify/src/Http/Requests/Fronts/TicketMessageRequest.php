<?php

namespace Dev\Ticksify\Http\Requests\Fronts;

use Dev\Support\Http\Requests\Request;

class TicketMessageRequest extends Request
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:10000'],
        ];
    }
}
