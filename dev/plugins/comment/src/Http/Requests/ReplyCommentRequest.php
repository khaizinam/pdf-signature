<?php

namespace Dev\Comment\Http\Requests;

use Dev\Support\Http\Requests\Request;

class ReplyCommentRequest extends Request
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:1000'],
        ];
    }
}
