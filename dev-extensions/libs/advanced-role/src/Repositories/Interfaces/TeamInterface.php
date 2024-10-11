<?php

namespace Dev\AdvancedRole\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface TeamInterface extends RepositoryInterface
{
    public function getAllTeams(int|string $memberId);
}
