<?php

namespace Dev\Block\Tables;

use Dev\Base\Facades\Html;
use Dev\Block\Models\Block;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class BlockTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Block::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('block.create'))
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('block.edit'),
                FormattedColumn::make('alias')
                    ->title(trans('core/base::tables.shortcode'))
                    ->alignStart()
                    ->getValueUsing(function (FormattedColumn $column) {
                        $value = $column->getItem()->alias;

                        if (! function_exists('shortcode')) {
                            return $value;
                        }

                        return shortcode()->generateShortcode('static-block', ['alias' => $value]);
                    })
                    ->renderUsing(fn (FormattedColumn $column) => Html::tag('code', $column->getValue()))
                    ->copyable()
                    ->copyableState(function (FormattedColumn $column) {
                        $value = $column->getItem()->alias;

                        if (! function_exists('shortcode')) {
                            return $value;
                        }

                        return shortcode()->generateShortcode('static-block', ['alias' => $value]);
                    }),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addActions([
                EditAction::make()->route('block.edit'),
                DeleteAction::make()->route('block.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('block.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query
                    ->select([
                        'id',
                        'alias',
                        'name',
                        'created_at',
                        'status',
                    ]);
            });
    }
}
