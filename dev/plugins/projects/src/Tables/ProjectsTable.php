<?php

namespace Dev\Projects\Tables;

use Dev\Projects\Models\Projects;
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

class ProjectsTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Projects::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('projects.create'))
            ->addActions([
                EditAction::make()->route('projects.edit'),
                DeleteAction::make()->route('projects.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('projects.destroy'),
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
                ]);
            });
    }
}
