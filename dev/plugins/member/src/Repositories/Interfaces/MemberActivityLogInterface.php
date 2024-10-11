<?php

namespace Dev\Member\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MemberActivityLogInterface extends RepositoryInterface
{
    public function getAllLogs(int|string $memberId, int $paginate = 10): LengthAwarePaginator;
}
