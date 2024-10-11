<?php

namespace Dev\Contact\Tables;

use Dev\Contact\Models\CustomField;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\EnumColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class CustomFieldTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(CustomField::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('contacts.custom-fields.create')->permission('contacts.edit'))
            ->addBulkChanges([
                NameBulkChange::make()->validate('required|max:120'),
                CreatedAtBulkChange::make(),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('contacts.edit'))
            ->addActions([
                EditAction::make()->route('contacts.custom-fields.edit')->permission('contacts.edit'),
                DeleteAction::make()->route('contacts.custom-fields.destroy')->permission('contacts.edit'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('contacts.custom-fields.edit')->permission('contacts.edit'),
                EnumColumn::make('type')
                    ->title(trans('plugins/contact::contact.custom_field.type'))
                    ->alignLeft(),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(fn (Builder $query) => $query->select([
                'id',
                'name',
                'type',
                'created_at',
            ]));
    }
}
