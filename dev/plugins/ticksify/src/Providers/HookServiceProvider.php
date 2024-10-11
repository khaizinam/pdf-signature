<?php

namespace Dev\Ticksify\Providers;

use Dev\Base\Facades\Html;
use Dev\Base\Supports\ServiceProvider;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Ticksify\Enums\TicketStatus;
use Dev\Ticksify\Models\Ticket;
use Dev\Ticksify\Tables\TicketTable;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(BASE_FILTER_APPEND_MENU_NAME, function (?string $html, string $id): ?string {
            if ($id !== 'cms-plugins-ticksify-tickets' && $id !== 'cms-plugins-ticksify') {
                return $html;
            }

            $tickets = Ticket::query()
                ->where('status', TicketStatus::OPEN)
                ->count();

            return $html .
                Html::tag(
                    'span',
                    trans('plugins/ticksify::ticksify.menu_counter', ['count' => number_format($tickets)]),
                    ['class' => 'badge bg-warning text-warning-fg']
                );
        }, 999, 2);

        add_filter(BASE_FILTER_TABLE_BEFORE_RENDER, function (?string $html, TableAbstract $table): ?string {
            if (! $table instanceof TicketTable) {
                return $html;
            }

            $stats = Ticket::query()
                ->withStatistics()
                ->first();

            $statUrl = function (?string $status = null) {
                $params = [];

                if ($status !== null) {
                    $params = [
                        'filter_table_id' => 'dev-ticksify-tables-ticket-table',
                        'class' => TicketTable::class,
                        'filter_columns' => ['status'],
                        'filter_operators' => ['='],
                        'filter_values' => [$status],
                    ];
                }

                return route('ticksify.tickets.index', $params);
            };

            return $html . view('plugins/ticksify::tickets.partials.stats', compact('stats', 'statUrl'));
        }, 999, 2);
    }
}
