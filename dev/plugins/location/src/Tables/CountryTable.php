<?php

namespace Dev\Location\Tables;

use Dev\Location\Models\Country;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\BulkChanges\TextBulkChange;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class CountryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Country::class)
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('country.edit'),
                Column::make('nationality')
                    ->title(trans('plugins/location::country.nationality'))
                    ->alignStart(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addHeaderAction(CreateHeaderAction::make()->route('country.create'))
            ->addActions([
                EditAction::make()->route('country.edit'),
                DeleteAction::make()->route('country.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('country.destroy'))
            ->addBulkChanges([
                TextBulkChange::make()
                    ->name('nationality')
                    ->title(trans('plugins/location::country.nationality')),
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'name',
                        'nationality',
                        'created_at',
                        'status',
                    ]);
            });
    }
}
