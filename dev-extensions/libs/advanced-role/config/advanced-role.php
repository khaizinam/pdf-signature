<?php

use Dev\AdvancedRole\Models\Member;

return [
    'provider' => [
        'model' => Member::class,
        'guard' => 'member',
        'password_broker' => 'members',
        'verify_email' => true,
    ],
    "cache_time_second" => 30
];
