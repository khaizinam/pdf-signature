<?php

namespace Dev\ContractManagement\Tables;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Facades\Html;
use Dev\ContractManagement\Models\ContractManagement;
use Dev\ContractManagement\Repositories\Interfaces\ContractManagementInterface;
use Dev\Slug\Models\Slug;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ContractManagementTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ContractManagementInterface $inteface)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $inteface;

        if (!Auth::user()->hasAnyPermission(['contract-management.edit', 'contract-management.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }
    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate(Arr::get($item,'created_at','...'),'Y-m-d h:m:s');
            })
            ->addColumn('slug', function ($item) {
                $slug = Slug::where("reference_type", ContractManagement::class)->where("reference_id", $item->id)->first();
                return Html::link(route("public.contract-view", Arr::get($slug,'key','')), Arr::get($slug,'key','')) ;
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('contract-management.edit', 'contract-management.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query()
    {
        $query = $this->repository->getModel()
            ->select([
               'id',
               'name',
               'status',
               'created_at',
           ])->with('slugable');

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'title' => trans('Name'),
                'class' => 'text-center',
            ],
            'slug' => [
                'title' => trans('Trang chính'),
                'class' => 'text-center',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('contract-management.create'), 'contract-management.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('contract-management.deletes'), 'contract-management.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
            'status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
        ];
    }

    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }

    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
