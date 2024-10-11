<?php

namespace Dev\ContractManagement\Tables;

use Dev\ContractManagement\Models\ContractManagement;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\Columns\NameColumn;
use Illuminate\Database\Eloquent\Builder;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\ImageColumn;

class ContractManagementTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ContractManagement::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('contract-management.create'))
            ->addActions([

                EditAction::make()->route('contract-management.edit'),
                DeleteAction::make()->route('contract-management.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make(),
                ImageColumn::make(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('contract-management.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'created_at',
                    'status',
                    'image',
                ]);
            });
    }
}
