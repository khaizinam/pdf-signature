<?php

namespace Dev\RequestLog\Tables;

use Dev\RequestLog\Models\RequestLog;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\Columns\Column;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\LinkableColumn;
use Dev\Table\HeaderActions\HeaderAction;
use Illuminate\Database\Eloquent\Builder;

class RequestLogTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(RequestLog::class)
            ->setView('plugins/request-log::table')
            ->addColumns([
                IdColumn::make(),
                LinkableColumn::make('url')
                    ->title(trans('core/base::tables.url'))
                    ->alignStart()
                    ->externalLink(),
                Column::make('status_code')
                    ->title(trans('plugins/request-log::request-log.status_code')),
                Column::make('count')
                    ->title(trans('plugins/request-log::request-log.count')),
            ])
            ->addHeaderActions([
                HeaderAction::make('empty')
                    ->label(trans('plugins/request-log::request-log.delete_all'))
                    ->icon('ti ti-trash')
                    ->url('javascript:void(0)')
                    ->attributes(['class' => 'empty-request-logs-button']),
            ])
            ->addAction(DeleteAction::make()->route('request-log.destroy'))
            ->addBulkAction(DeleteBulkAction::make()->permission('request-log.destroy'))
            ->queryUsing(function (Builder $query) {
                $query
                    ->select([
                    'id',
                    'url',
                    'status_code',
                    'count',
                ]);
            });
    }
}
