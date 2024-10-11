<?php

namespace Dev\Turnstile\Rules;

use Closure;
use Dev\Turnstile\Facades\Turnstile as TurnstileFacade;
use Illuminate\Contracts\Validation\ValidationRule;

class Turnstile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail(__('validation.required'));

            return;
        }

        if (TurnstileFacade::verify($value)['success'] !== true) {
            $fail(trans('plugins/turnstile::turnstile.validation.turnstile'));

            return;
        }
    }
}
