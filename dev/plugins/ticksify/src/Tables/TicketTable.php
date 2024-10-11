<?php

namespace Dev\Ticksify\Tables;

use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\DateTimeColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\LinkableColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Ticksify\Enums\TicketPriority;
use Dev\Ticksify\Enums\TicketStatus;
use Dev\Ticksify\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;

class TicketTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Ticket::class)
            ->queryUsing(fn (Builder $query) => $query->with(['category', 'sender']))
            ->addActions([
                EditAction::make()->route('ticksify.tickets.show'),
                DeleteAction::make()->route('ticksify.tickets.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('sender_type')
                    ->label(trans('plugins/ticksify::ticksify.user'))
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->sender->name),
                NameColumn::make('title')
                    ->label(trans('plugins/ticksify::ticksify.title'))
                    ->route('ticksify.tickets.show'),
                LinkableColumn::make('category_id')
                    ->label(trans('plugins/ticksify::ticksify.category'))
                    ->urlUsing(fn (LinkableColumn $column) => route('ticksify.categories.edit', $column->getItem()->category_id))
                    ->getValueUsing(fn (LinkableColumn $column) => $column->getItem()->category->name),
                StatusColumn::make()->alignStart(),
                DateTimeColumn::make('created_at'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make()
                    ->choices(TicketStatus::labels()),
                StatusBulkChange::make()
                    ->name('priority')
                    ->title(trans('plugins/ticksify::ticksify.priority'))
                    ->choices(TicketPriority::labels()),
            ])
            ->addBulkAction(DeleteBulkAction::make());
    }
}
