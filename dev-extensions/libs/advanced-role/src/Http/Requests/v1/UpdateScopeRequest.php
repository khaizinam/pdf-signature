<?php

namespace Dev\AdvancedRole\Http\Requests\v1;

use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateScopeRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => [
                'unique:app_permission_scopes,name,' . $this->id,
                Rule::in(['none', 'basic', 'local', 'deep', 'global'])
            ],
            'display_name' => 'required|min:2|max:191'
        ];
    }
}
