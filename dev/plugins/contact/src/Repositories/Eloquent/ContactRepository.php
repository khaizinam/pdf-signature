<?php

namespace Dev\Contact\Repositories\Eloquent;

use Dev\Contact\Enums\ContactStatusEnum;
use Dev\Contact\Repositories\Interfaces\ContactInterface;
use Dev\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Collection;

class ContactRepository extends RepositoriesAbstract implements ContactInterface
{
    public function getUnread(array $select = ['*']): Collection
    {
        $data = $this->model
            ->where('status', ContactStatusEnum::UNREAD)
            ->select($select)
            ->orderByDesc('created_at')
            ->get();

        $this->resetModel();

        return $data;
    }

    public function countUnread(): int
    {
        $data = $this->model->where('status', ContactStatusEnum::UNREAD)->count();
        $this->resetModel();

        return $data;
    }
}
