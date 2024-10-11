<?php

namespace ArchiElite\UrlShortener\Tables;

use ArchiElite\UrlShortener\Models\Analytics;
use ArchiElite\UrlShortener\Models\UrlShortener;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\Action;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\LinkableColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class UrlShortenerTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(UrlShortener::class)
            ->addHeaderAction(CreateHeaderAction::make()->url(route('url_shortener.create')))
            ->addColumns([
                IdColumn::make(),
                LinkableColumn::make('long_url')
                    ->urlUsing(function (LinkableColumn $column) {
                        return route('url_shortener.edit', $column->getItem()->getKey());
                    })
                    ->label(trans('plugins/url-shortener::url-shortener.url')),
                LinkableColumn::make('short_url')
                    ->urlUsing(function (LinkableColumn $column) {
                        return route('url_shortener.go', $column->getItem()->short_url);
                    })
                    ->label(trans('plugins/url-shortener::url-shortener.name'))
                    ->copyable()
                    ->copyableState(function (LinkableColumn $column) {
                        return route('url_shortener.go', $column->getItem()->short_url);
                    }),
                FormattedColumn::make('clicks')
                    ->getValueUsing(function (FormattedColumn $column): int {
                        return Analytics::getClicks($column->getItem()->short_url);
                    }),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addActions([
                Action::make('analytics')
                    ->color('info')
                    ->icon('ti ti-brand-google-analytics')
                    ->label(trans('plugins/url-shortener::analytics.analytics'))
                    ->permission('url_shortener.analytics')
                    ->url(function (Action $action) {
                        return route('url_shortener.analytics', $action->getItem()->short_url);
                    }),
                EditAction::make()->route('url_shortener.edit'),
                DeleteAction::make()->route('url_shortener.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make())
            ->addBulkChanges([
                NameBulkChange::make()
                    ->name('long_url')
                    ->title(trans('plugins/url-shortener::url-shortener.url')),
                NameBulkChange::make()
                    ->name('short_url')
                    ->title(trans('plugins/url-shortener::url-shortener.name')),
            ])
            ->queryUsing(function (EloquentBuilder $query) {
                return $query
                    ->select([
                        'id',
                        'long_url',
                        'short_url',
                        'created_at',
                        'status',
                    ]);
            });
    }
}
