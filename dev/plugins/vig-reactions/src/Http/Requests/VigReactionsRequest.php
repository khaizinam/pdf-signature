<?php

namespace Dev\VigReactions\Http\Requests;

use Dev\Support\Http\Requests\Request;

class VigReactionsRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'              => 'required',
            'reaction_id'       => 'required',
            'reaction_type'     => 'required',
        ];
    }
}
