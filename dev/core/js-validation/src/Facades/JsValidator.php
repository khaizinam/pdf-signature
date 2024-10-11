<?php

namespace Dev\JsValidation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dev\JsValidation\Javascript\JavascriptValidator make(array $rules, array $messages = [], array $customAttributes = [], string|null $selector = null)
 * @method static \Dev\JsValidation\Javascript\JavascriptValidator formRequest($formRequest, $selector = null)
 * @method static \Dev\JsValidation\Javascript\JavascriptValidator validator(\Illuminate\Validation\Validator $validator, string|null $selector = null)
 *
 * @see \Dev\JsValidation\JsValidatorFactory
 */
class JsValidator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'js-validator';
    }
}
