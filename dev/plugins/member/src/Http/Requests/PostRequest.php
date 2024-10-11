<?php

namespace Dev\Member\Http\Requests;

use Dev\Base\Rules\MediaImageRule;
use Dev\Blog\Http\Requests\PostRequest as BasePostRequest;

class PostRequest extends BasePostRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'image_input' => ['nullable', new MediaImageRule()],
        ];
    }
}
