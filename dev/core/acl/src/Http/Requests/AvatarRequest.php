<?php

namespace Dev\ACL\Http\Requests;

use Dev\Media\Facades\AppMedia;
use Dev\Support\Http\Requests\Request;

class AvatarRequest extends Request
{
    public function rules(): array
    {
        return [
            'avatar_file' => AppMedia::imageValidationRule(),
        ];
    }
}
