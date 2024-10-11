<?php

namespace Dev\Comment\Http\Requests\Fronts;

use Dev\Captcha\Facades\Captcha;
use Dev\Support\Http\Requests\Request;
use Dev\Comment\Http\Requests\CommentRequest as BaseCommentRequest;
use Dev\Comment\Support\CommentHelper;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CommentRequest extends Request
{
    protected function prepareForValidation(): void
    {
        $preparedData = CommentHelper::preparedDataForFill();

        $this->merge($preparedData);
    }

    public function rules(): array
    {
        $rules = [
            'reference_id' => [Rule::when($this->has('reference_type'), 'required', 'nullable'), 'string'],
            'reference_type' => [Rule::when($this->has('reference_id'), 'required', 'nullable'), 'string'],
            'reference_url' => [Rule::when(! $this->has('reference_id') && ! $this->has('reference_type'), 'required', 'nullable'), 'string'],
            ...Arr::except((new BaseCommentRequest())->rules(), 'status'),
        ];

        if (CommentHelper::isEnableReCaptcha()) {
            $rules = [...$rules, ...Captcha::rules()];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return CommentHelper::isEnableReCaptcha() ? Captcha::attributes() : [];
    }
}
