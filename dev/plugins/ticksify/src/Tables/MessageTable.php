<?php

namespace Dev\Ticksify\Tables;

use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\LinkableColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Ticksify\Models\Message;
use Illuminate\Database\Eloquent\Builder;

class MessageTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Message::class)
            ->queryUsing(fn (Builder $query) => $query->with('ticket'))
            ->addActions([
                EditAction::make()->route('ticksify.messages.edit'),
                DeleteAction::make()->route('ticksify.messages.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                LinkableColumn::make('ticket_id')
                    ->label(trans('plugins/ticksify::ticksify.ticket'))
                    ->urlUsing(fn (LinkableColumn $column) => route('ticksify.tickets.show', $column->getItem()->ticket_id))
                    ->getValueUsing(fn (LinkableColumn $column) => $column->getItem()->ticket->title),
                Column::make('content')
                    ->label(trans('plugins/ticksify::ticksify.content')),
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
