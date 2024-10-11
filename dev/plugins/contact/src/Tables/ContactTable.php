<?php

namespace Dev\Contact\Tables;

use Dev\Contact\Enums\ContactStatusEnum;
use Dev\Contact\Exports\ContactExport;
use Dev\Contact\Models\Contact;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\EmailBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\PhoneBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\EmailColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\PhoneColumn;
use Dev\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class ContactTable extends TableAbstract
{
    protected string $exportClass = ContactExport::class;

    public function setup(): void
    {
        $this
            ->model(Contact::class)
            ->addActions([
                EditAction::make()->route('contacts.edit'),
                DeleteAction::make()->route('contacts.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('contacts.edit'),
                EmailColumn::make()->linkable()->withEmptyState(),
                PhoneColumn::make()->linkable()->withEmptyState(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('contacts.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                EmailBulkChange::make(),
                StatusBulkChange::make()
                    ->choices(ContactStatusEnum::labels())
                    ->validate(['required', Rule::in(ContactStatusEnum::values())]),
                CreatedAtBulkChange::make(),
                PhoneBulkChange::make()->title(trans('plugins/contact::contact.sender_phone')),
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'name',
                        'phone',
                        'email',
                        'created_at',
                        'status',
                    ]);
            });
    }

    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
