<?php

namespace ArchiElite\TwoFactorAuthentication\Http\Requests\Settings;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;

class TwoFactorAuthenticationSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            '2fa_enabled' => [new OnOffRule()],
        ];
    }
}
