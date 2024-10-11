<?php

namespace Dev\AdvancedRole\Http\Requests\v1;

use Illuminate\Support\Arr;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Dev\AdvancedRole\Repositories\Interfaces\TeamInterface;
use Dev\AdvancedRole\Models\Member;

class StoreTeamRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:191',
            'parent_id' => [
                'nullable',
                Rule::exists(config('laratrust.tables.teams', 'app_teams'), 'id')
                    ->where('author_id', request()->user()->id)
                    ->where('author_type', Member::class)
            ]
        ];
    }
}
