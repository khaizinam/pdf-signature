<?php

namespace Dev\Base\Repositories\Eloquent;

use Dev\Base\Models\BaseModel;
use Dev\Base\Models\BaseQueryBuilder;
use Dev\Base\Models\MetaBox;
use Dev\Base\Repositories\Interfaces\MetaBoxInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MetaBoxRepository extends RepositoriesAbstract implements MetaBoxInterface
{
    public function __construct(protected BaseModel|BaseQueryBuilder|Builder|Model $model)
    {
        parent::__construct(new MetaBox());
    }
}
