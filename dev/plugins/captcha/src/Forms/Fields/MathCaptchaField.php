<?php

namespace Dev\Captcha\Forms\Fields;

use Dev\Base\Forms\FormField;

class MathCaptchaField extends FormField
{
    protected function getTemplate(): string
    {
        return 'plugins/captcha::forms.fields.math-captcha';
    }
}
