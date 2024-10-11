<?php

namespace ArchiElite\TwoFactorAuthentication\Actions;

use ArchiElite\TwoFactorAuthentication\TwoFactorAuthenticationProvider;
use Dev\ACL\Models\User;

class GenerateTwoFactorQrCodeUrl
{
    public function __invoke(User $user, string $secret): string
    {
        return app(TwoFactorAuthenticationProvider::class)->qrCodeUrl(
            config('app.name'),
            $user->email,
            decrypt($secret)
        );
    }
}
