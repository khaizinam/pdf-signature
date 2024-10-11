<?php

namespace Dev\AdvancedRole\Http\Requests;

use Dev\Support\Http\Requests\Request;

class AdvancedRoleSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'advanced-role_enabled' => 'nullable|in:0,1',
        ];
    }
}
