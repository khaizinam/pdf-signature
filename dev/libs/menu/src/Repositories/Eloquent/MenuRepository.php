<?php

namespace Dev\Menu\Repositories\Eloquent;

use Dev\Base\Models\BaseModel;
use Dev\Menu\Models\Menu;
use Dev\Menu\Repositories\Interfaces\MenuInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;

class MenuRepository extends RepositoriesAbstract implements MenuInterface
{
    public function findBySlug(string $slug, bool $active, array $select = [], array $with = []): ?BaseModel
    {
        $data = $this->model->where('slug', $slug);

        if ($active) {
            $data = $data->wherePublished();
        }

        if (! empty($select)) {
            $data = $data->select($select);
        }

        if (! empty($with)) {
            $data = $data->with($with);
        }

        $data = $this->applyBeforeExecuteQuery($data, true)->first();

        $this->resetModel();

        return $data;
    }

    public function createSlug(string $name): string
    {
        return Menu::createSlug($name, null);
    }
}
