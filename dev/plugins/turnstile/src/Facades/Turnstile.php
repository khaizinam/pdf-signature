<?php

namespace Dev\Turnstile\Facades;

use Dev\Turnstile\Contracts\Turnstile as TurnstileContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static static registerForm(string $form, string $request, string $title)
 * @method static array getForms()
 * @method static bool isEnabled()
 * @method static bool isEnabledForForm(string $form)
 * @method static string getFormByRequest(string $request)
 * @method static string getFormSettingKey(string $form)
 * @method static array verify(string $response)
 * @method static string getSettingKey(string $key)
 * @method static mixed|null getSetting(string $key, mixed|null $default = null)
 *
 * @see \Dev\Turnstile\Turnstile
 */
class Turnstile extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TurnstileContract::class;
    }
}
