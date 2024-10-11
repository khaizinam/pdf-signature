<?php

namespace Dev\CustomField\Tables;

use Dev\CustomField\Models\FieldGroup;
use Dev\CustomField\Tables\Actions\ExportAction;
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
use Dev\Table\HeaderActions\HeaderAction;
use Illuminate\Database\Eloquent\Builder;

class CustomFieldTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(FieldGroup::class)
            ->addHeaderActions([
                CreateHeaderAction::make()->route('custom-fields.create'),
                HeaderAction::make('import-field-group')
                    ->label(trans('plugins/custom-field::base.import'))
                    ->icon('ti ti-cloud-upload')
                    ->url('#')
                    ->attributes(['class' => 'custom-import-button']),
            ])
            ->setView('plugins/custom-field::list')
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('title')->route('custom-fields.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addActions([
                ExportAction::make()
                    ->route('custom-fields.export')
                    ->permission('custom-fields.index'),
                EditAction::make()->route('custom-fields.edit'),
                DeleteAction::make()->route('custom-fields.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('custom-fields.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make()->name('title'),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'title',
                        'status',
                        'order',
                        'created_at',
                    ]);
            });
    }
}
