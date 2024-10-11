<?php

namespace Dev\AdvancedRole\Http\Requests\v1;

use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Dev\AdvancedRole\Repositories\Interfaces\PermissionInterface;

class StoreRoleRequest extends Request
{
    public function rules(): array
    {
        $permissions = app(PermissionInterface::class)->advancedGet([
            'select' => ['name']
        ]);
        $listPermissions = [];
        if ($permissions) {
            $listPermissions = $permissions->pluck('name')->toArray() ?? [];
        }

        return [
            'name' => [
                'required',
                'min:2',
                'max:50',
                'unique:' . config('laratrust.tables.roles', 'app_roles') . ',name'
            ],
            'permissions' => [
                'nullable',
            ],
            'permissions.*.name' => [
                'required',
                Rule::in($listPermissions)
            ],
            'permissions.*.scope' => [
                'required',
                Rule::in(['none', 'basic', 'local', 'deep', 'global'])
            ]
        ];
    }
}
