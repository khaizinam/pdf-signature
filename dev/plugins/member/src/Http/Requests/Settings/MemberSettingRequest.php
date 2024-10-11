<?php

namespace Dev\Member\Http\Requests\Settings;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;

class MemberSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'verify_account_email' => new OnOffRule(),
        ];
    }
}
