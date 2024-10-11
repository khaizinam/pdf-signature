<?php

namespace Dev\Location\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Rules\MediaImageRule;
use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CityRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'state_id' => ['nullable', 'exists:states,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'slug' => [
                'nullable',
                'string',
                Rule::unique('cities', 'slug')->ignore($this->route('city')),
            ],
            'image' => ['nullable', 'string', new MediaImageRule()],
            'order' => ['required', 'integer', 'min:0', 'max:127'],
            'status' => [Rule::in(BaseStatusEnum::values())],
            'is_default' => [new OnOffRule()],
        ];
    }
}
