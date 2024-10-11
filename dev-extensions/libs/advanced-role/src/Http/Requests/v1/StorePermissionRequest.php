<?php

namespace Dev\AdvancedRole\Http\Requests\v1;

use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Dev\AdvancedRole\Repositories\Interfaces\PermissionInterface;

class StorePermissionRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:191',
            'display_name' => 'required|min:2|max:191'
        ];
    }
}
