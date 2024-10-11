<?php

namespace Dev\Media\Http\Requests;

use Dev\Support\Http\Requests\Request;

class MediaListRequest extends Request
{
    public function rules(): array
    {
        return [
            'folder_id' => ['nullable', 'string'],
        ];
    }
}
