<?php

namespace Dev\Location\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface StateInterface extends RepositoryInterface
{
    public function filters(?string $keyword, ?int $limit = 10, array $with = [], array $select = ['states.*']): Collection;
}
