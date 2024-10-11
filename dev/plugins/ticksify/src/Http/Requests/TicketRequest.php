<?php

namespace Dev\Ticksify\Http\Requests;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;
use Dev\Ticksify\Enums\TicketPriority;
use Dev\Ticksify\Enums\TicketStatus;
use Illuminate\Validation\Rule;

class TicketRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => [Rule::in(TicketStatus::values())],
            'priority' => [Rule::in(TicketPriority::values())],
            'is_resolved' => [new OnOffRule()],
            'is_locked' => [new OnOffRule()],
        ];
    }
}
