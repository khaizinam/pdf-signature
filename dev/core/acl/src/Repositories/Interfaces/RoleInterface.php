<?php

namespace Dev\ACL\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface RoleInterface extends RepositoryInterface
{
    public function createSlug(string $name, int|string $id): string;
}
