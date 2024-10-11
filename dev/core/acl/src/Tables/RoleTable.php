<?php

namespace Dev\ACL\Tables;

use Dev\ACL\Models\Role;
use Dev\Base\Facades\BaseHelper;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\LinkableColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class RoleTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Role::class)
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('roles.edit'),
                FormattedColumn::make('description')
                    ->title(trans('core/base::tables.description'))
                    ->alignStart()
                    ->withEmptyState(),
                CreatedAtColumn::make(),
                LinkableColumn::make('created_by')
                    ->urlUsing(fn (LinkableColumn $column) => $column->getItem()->author->url)
                    ->title(trans('core/acl::permissions.created_by'))
                    ->width(100)
                    ->getValueUsing(function (LinkableColumn $column) {
                        return BaseHelper::clean($column->getItem()->author->name);
                    })
                    ->externalLink()
                    ->withEmptyState(),
            ])
            ->addHeaderAction(CreateHeaderAction::make()->route('roles.create'))
            ->addActions([
                EditAction::make()->route('roles.edit'),
                DeleteAction::make()->route('roles.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('roles.destroy'))
            ->addBulkChange(NameBulkChange::make())
            ->queryUsing(function (Builder $query) {
                $query
                    ->with('author')
                    ->select([
                        'id',
                        'name',
                        'description',
                        'created_at',
                        'created_by',
                    ]);
            });
    }
}
