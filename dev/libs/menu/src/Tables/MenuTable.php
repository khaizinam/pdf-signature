<?php

namespace Dev\Menu\Tables;

use Dev\Base\Facades\BaseHelper;
use Dev\Menu\Facades\Menu as MenuFacade;
use Dev\Menu\Models\Menu;
use Dev\Menu\Models\MenuLocation;
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
use Illuminate\Support\Arr;

class MenuTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Menu::class)
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('menus.edit'),
                FormattedColumn::make('locations_display')
                    ->label(trans('libs/menu::menu.locations'))
                    ->orderable(false)
                    ->searchable(false)
                    ->getValueUsing(function (FormattedColumn $column) {
                        $locations = $column
                            ->getItem()
                            ->locations
                            ->sortBy('name')
                            ->map(function (MenuLocation $location) {
                                $locationName = Arr::get(MenuFacade::getMenuLocations(), $location->location);

                                if (! $locationName) {
                                    return null;
                                }

                                return BaseHelper::renderBadge($locationName, 'info', ['class' => 'me-1']);
                            })
                            ->all();

                        return implode(', ', $locations);
                    })
                    ->withEmptyState(),
                FormattedColumn::make('items_count')
                    ->label(trans('libs/menu::menu.items'))
                    ->orderable(false)
                    ->searchable(false)
                    ->getValueUsing(function (FormattedColumn $column) {
                        return BaseHelper::renderIcon('ti ti-link') . ' '
                            . number_format($column->getItem()->menu_nodes_count);
                    }),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addHeaderAction(CreateHeaderAction::make()->route('menus.create'))
            ->addActions([
                EditAction::make()->route('menus.edit'),
                DeleteAction::make()->route('menus.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('menus.destroy'))
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query
                    ->select([
                        'id',
                        'name',
                        'created_at',
                        'status',
                    ])
                    ->with('locations')
                    ->withCount('menuNodes');
            });
    }
}
