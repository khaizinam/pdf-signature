<?php

namespace Dev\Blog\Tables;

use Dev\Blog\Models\Tag;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class TagTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Tag::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('tags.create'))
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('tags.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addActions([
                EditAction::make()->route('tags.edit'),
                DeleteAction::make()->route('tags.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('tags.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'name',
                        'created_at',
                        'status',
                    ]);
            });
    }
}
