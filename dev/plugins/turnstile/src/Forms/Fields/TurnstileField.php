<?php

namespace Dev\Turnstile\Forms\Fields;

use Dev\Base\Forms\FormField;
use Dev\Turnstile\Facades\Turnstile;

class TurnstileField extends FormField
{
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true): string
    {
        return parent::render($options, $showLabel, $showField, $showError)
            . view('plugins/turnstile::script', ['siteKey' => Turnstile::getSetting('site_key')])->render();
    }

    protected function getTemplate(): string
    {
        return 'plugins/turnstile::forms.fields.turnstile';
    }
}
