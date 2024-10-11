<?php

namespace Dev\VigReactions\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface VigReactionsInterface extends RepositoryInterface
{
    /**
     * @param array $params
     * @return LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection|mixed
     */
    public function advancedGetReaction(array $params = []);
}
