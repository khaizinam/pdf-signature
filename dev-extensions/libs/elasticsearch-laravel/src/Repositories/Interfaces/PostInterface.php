<?php

namespace Dev\ElasticsearchLaravel\Repositories\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface PostInterface extends RepositoryInterface
{
    public function getSearch(?Request $request, int $limit = 10, int $paginate = 10);
}
