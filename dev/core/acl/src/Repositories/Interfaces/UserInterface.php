<?php

namespace Dev\ACL\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    public function getUniqueUsernameFromEmail(string $email): string;
}
