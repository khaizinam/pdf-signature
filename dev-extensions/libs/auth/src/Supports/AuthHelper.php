<?php

namespace Dev\Auth\Supports;

use App\Models\User;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class AuthHelper
{
    public function guard(): string|null
    {
        return 'advanced-role';
    }
    public function passwordBroker(): string|null
    {
        return 'members';
    }
    public function enabled(): bool
    {
        return setting('auth_enabled', 0) == 1;
    }
    public function accountVerify(): bool
    {
        return setting(
            'verify_account_email',
            config('plugins.member.general.verify_email', 0)
        ) == 1;
    }
}
