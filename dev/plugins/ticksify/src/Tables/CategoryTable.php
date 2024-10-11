<?php

namespace Dev\Ticksify\Tables;

use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Dev\Ticksify\Models\Category;

class CategoryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Category::class)
            ->addHeaderAction(
                CreateHeaderAction::make()->route('ticksify.categories.create')
            )
            ->addActions([
                EditAction::make()->route('ticksify.categories.edit'),
                DeleteAction::make()->route('ticksify.categories.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('ticksify.categories.edit'),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
            ])
            ->addBulkAction(DeleteBulkAction::make());
    }
}
