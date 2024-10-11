<?php

namespace Dev\SanctumToken\Tables;

use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\DateTimeColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Dev\SanctumToken\Models\PersonalAccessToken;
use Illuminate\Database\Eloquent\Builder;

class SanctumTokenTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->setView('plugins/sanctum-token::table')
            ->model(PersonalAccessToken::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('sanctum-token.create'))
            ->addAction(DeleteAction::make()->route('sanctum-token.destroy'))
            ->addColumns([
                IdColumn::make(),
                NameColumn::make(),
                Column::make('abilities')
                    ->label(__('plugins/sanctum-token::sanctum-token.abilities')),
                DateTimeColumn::make('last_used_at')
                    ->label(__('plugins/sanctum-token::sanctum-token.last_used_at')),
                CreatedAtColumn::make(),
            ])
            ->addBulkAction(DeleteBulkAction::make())
            ->queryUsing(fn (Builder $query) => $query->select([
                'id',
                'name',
                'abilities',
                'last_used_at',
                'created_at',
            ]));
    }
}
