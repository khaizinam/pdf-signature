<?php

namespace Dev\Block\Repositories\Eloquent;

use Dev\Block\Models\Block;
use Dev\Block\Repositories\Interfaces\BlockInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;

class BlockRepository extends RepositoriesAbstract implements BlockInterface
{
    public function createSlug(?string $name, int|string|null $id): string
    {
        return Block::createSlug($name, $id, 'alias');
    }
}
