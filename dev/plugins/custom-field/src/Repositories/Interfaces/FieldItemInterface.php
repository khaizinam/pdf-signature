<?php

namespace Dev\CustomField\Repositories\Interfaces;

use Dev\CustomField\Models\FieldItem;
use Dev\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface FieldItemInterface extends RepositoryInterface
{
    public function deleteFieldItem(array|int|string|null $id): int;

    public function getGroupItems(int|string|null $groupId, int|string|null $parentId = null): Collection;

    public function updateWithUniqueSlug(int|string|null $id, array $data): ?FieldItem;
}
