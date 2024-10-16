<?php

namespace Dev\Turnstile\Http\Requests\Settings;

use Dev\Base\Rules\OnOffRule;
use Dev\Support\Http\Requests\Request;
use Dev\Turnstile\Facades\Turnstile;

class TurnstileSettingRequest extends Request
{
    public function rules(): array
    {
        return [
            Turnstile::getSettingKey('enabled') => [new OnOffRule()],
            Turnstile::getSettingKey('site_key') => ['nullable', 'string'],
            Turnstile::getSettingKey('secret_key') => ['nullable', 'string'],
            ...$this->getFormRules(),
        ];
    }

    protected function getFormRules(): array
    {
        $rules = [];

        foreach (array_keys(Turnstile::getForms()) as $form) {
            $rules[Turnstile::getFormSettingKey($form)] = [new OnOffRule()];
        }

        return $rules;
    }
}
