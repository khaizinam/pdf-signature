<?php

namespace Dev\Member\Repositories\Eloquent;

use Dev\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MemberActivityLogRepository extends RepositoriesAbstract implements MemberActivityLogInterface
{
    public function getAllLogs(int|string $memberId, int $paginate = 10): LengthAwarePaginator
    {
        return $this->model
            ->where('member_id', $memberId)
            ->latest('created_at')
            ->paginate($paginate);
    }
}
