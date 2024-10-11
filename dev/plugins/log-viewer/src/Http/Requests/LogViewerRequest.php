<?php

namespace Dev\LogViewer\Http\Requests;

use Dev\Support\Http\Requests\Request;

class LogViewerRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
