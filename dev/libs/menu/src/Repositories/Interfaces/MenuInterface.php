<?php

namespace Dev\Menu\Repositories\Interfaces;

use Dev\Base\Models\BaseModel;
use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface MenuInterface extends RepositoryInterface
{
    public function findBySlug(string $slug, bool $active, array $select = [], array $with = []): ?BaseModel;

    public function createSlug(string $name): string;
}
