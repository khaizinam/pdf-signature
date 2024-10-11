<?php

namespace Dev\Block\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface BlockInterface extends RepositoryInterface
{
    public function createSlug(?string $name, int|string|null $id): string;
}
