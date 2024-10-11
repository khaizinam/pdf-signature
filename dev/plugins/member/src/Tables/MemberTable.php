<?php

namespace Dev\Member\Tables;

use Dev\Member\Models\Member;
use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\CreatedAtBulkChange;
use Dev\Table\BulkChanges\EmailBulkChange;
use Dev\Table\BulkChanges\NameBulkChange;
use Dev\Table\Columns\CreatedAtColumn;
use Dev\Table\Columns\EmailColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\ImageColumn;
use Dev\Table\Columns\NameColumn;
use Dev\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class MemberTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Member::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('member.create'))
            ->addColumns([
                IdColumn::make(),
                ImageColumn::make('avatar_thumb_url')
                    ->title(trans('plugins/member::member.avatar'))
                    ->fullMediaSize()
                    ->relative(),
                NameColumn::make()->route('member.edit')->orderable(false),
                EmailColumn::make()->linkable(),
                CreatedAtColumn::make(),
            ])
            ->addActions([
                EditAction::make()->route('member.edit'),
                DeleteAction::make()->route('member.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('member.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make()
                    ->name('first_name')
                    ->title(trans('plugins/member::member.first_name')),
                NameBulkChange::make()
                    ->name('last_name')
                    ->title(trans('plugins/member::member.last_name')),
                EmailBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function ($query) {
                return $query->select([
                    'id',
                    'avatar_id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at',
                ]);
            })
            ->onAjax(function (TableAbstract $table) {
                return $table->toJson(
                    $this->table
                        ->eloquent($this->query())
                        ->filter(function (Builder $query) {
                            $keyword = $this->request->input('search.value');

                            if (! $keyword) {
                                return $query;
                            }

                            return $query->where(function (Builder $query) use ($keyword) {
                                $likeKeyword = '%' . $keyword . '%';

                                $query
                                    ->where('id', $keyword)
                                    ->orWhere('first_name', 'LIKE', $likeKeyword)
                                    ->orWhere('last_name', 'LIKE', $likeKeyword)
                                    ->orWhereRaw('concat(first_name, " ", last_name) LIKE ?', $likeKeyword)
                                    ->orWhere('email', 'LIKE', $likeKeyword)
                                    ->orWhereDate('created_at', $keyword);
                            });
                        })
                );
            });
    }
}
