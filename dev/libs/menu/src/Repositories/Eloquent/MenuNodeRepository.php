<?php

namespace Dev\Menu\Repositories\Eloquent;

use Dev\Menu\Repositories\Interfaces\MenuNodeInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Collection;

class MenuNodeRepository extends RepositoriesAbstract implements MenuNodeInterface
{
    public function getByMenuId(int|string $menuId, int|string|null $parentId, array $select = ['*'], array $with = ['child']): Collection
    {
        $data = $this->model
            ->with($with)
            ->where([
                'menu_id' => $menuId,
                'parent_id' => $parentId,
            ]);

        if (! empty($select)) {
            $data = $data->select($select);
        }

        $data = $data->orderBy('position')->get();

        $this->resetModel();

        return $data;
    }
}
