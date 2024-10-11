<?php

declare(strict_types=1);

namespace Dev\EmailLog\Tables;

use Dev\Base\Facades\BaseHelper;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\Action;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\Columns\IdColumn;
use Dev\EmailLog\Models\EmailLog;
use Illuminate\Database\Eloquent\Builder;

class EmailLogTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(EmailLog::class)
            ->addActions([
                Action::make('view')
                    ->route('email-logs.edit')
                    ->label(trans('core/base::tables.view'))
                    ->icon('ti ti-eye'),
                DeleteAction::make()->route('email-logs.destroy'),
            ])
            ->queryUsing(fn (Builder $query) => $query->select([
                'id',
                'from',
                'to',
                'subject',
                'created_at',
            ])->latest())
            ->addColumns([
                IdColumn::make(),
                Column::make('subject')->label(trans('plugins/email-log::email-log.subject')),
                FormattedColumn::make('from')
                    ->label(trans('plugins/email-log::email-log.from'))
                    ->getValueUsing(function (FormattedColumn $column) {
                        $emailLog = $column->getItem();

                        return str_replace('<', '&lt;', $emailLog->from);
                    }),
                Column::make('to')->label(trans('plugins/email-log::email-log.to')),
                CreatedAtColumn::make()->dateFormat(BaseHelper::getDateTimeFormat()),
            ])
            ->addBulkAction(DeleteBulkAction::make());
    }
}
