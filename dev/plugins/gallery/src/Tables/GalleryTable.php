<?php

namespace Dev\Gallery\Tables;

use Dev\Gallery\Models\Gallery;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\ImageColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class GalleryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Gallery::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('galleries.create'))
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make(),
                NameColumn::make()->route('galleries.edit'),
                Column::make('order')
                    ->title(trans('core/base::tables.order'))
                    ->width(100),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addActions([
                EditAction::make()->route('galleries.edit'),
                DeleteAction::make()->route('galleries.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('galleries.destroy'),
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
                        'order',
                        'created_at',
                        'status',
                        'image',
                    ]);
            });
    }
}
