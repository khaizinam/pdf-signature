<?php

namespace Dev\AdvancedRole\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;
use Dev\AdvancedRole\Repositories\Interfaces\TeamInterface;
use Dev\AdvancedRole\Models\Member;

class TeamRepository extends RepositoriesAbstract implements TeamInterface
{
    public function getAllTeams(int|string $memberId)
    {
        $query = $this->model
            ->where('author_id', $memberId)
            ->where('author_type', Member::class);

        // if($paginate == 'all') {
            return $this->applyBeforeExecuteQuery($query)->get();
        // }

        // return $this->applyBeforeExecuteQuery($query)
        //     ->paginate((int)$paginate);
    }
}
