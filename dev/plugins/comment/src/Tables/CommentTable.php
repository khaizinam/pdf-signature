<?php

namespace Dev\Comment\Tables;

use Dev\Table\Abstracts\TableAbstract;
use Dev\Table\Actions\Action;
use Dev\Table\Actions\DeleteAction;
use Dev\Table\Actions\EditAction;
use Dev\Table\BulkActions\DeleteBulkAction;
use Dev\Table\BulkChanges\StatusBulkChange;
use Dev\Table\Columns\DateColumn;
use Dev\Table\Columns\FormattedColumn;
use Dev\Table\Columns\IdColumn;
use Dev\Table\Columns\LinkableColumn;
use Dev\Table\Columns\StatusColumn;
use Dev\Comment\Enums\CommentStatus;
use Dev\Comment\Models\Comment;
use Illuminate\Validation\Rule;

class CommentTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->setView('plugins/comment::tables.table')
            ->model(Comment::class)
            ->setOption('id', 'comment-table')
            ->addActions([
                Action::make('reply')
                    ->renderUsing(fn (Action $action) => view(
                        'plugins/comment::tables.reply-button',
                        compact('action')
                    )->render()),
                EditAction::make()->route('comment.comments.edit'),
                DeleteAction::make()->route('comment.comments.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('author')
                    ->label(trans('plugins/comment::comment.author'))
                    ->orderable(false)
                    ->searchable(false)
                    ->getValueUsing(function (FormattedColumn $column) {
                        return view(
                            'plugins/comment::tables.author-column',
                            ['item' => $column->getItem()]
                        )->render();
                    }),
                FormattedColumn::make('content')
                    ->label(trans('plugins/comment::comment.common.comment'))
                    ->getValueUsing(function (FormattedColumn $column) {
                        $model = $column->getItem();

                        $model->loadMissing('comment');

                        $url = $model->comment->reference_url ?? '#';
                        $url = sprintf('%s#comment-%s', $url, $model->comment?->getKey());

                        return view('plugins/comment::tables.content-column', compact('model', 'url'))->render();
                    })
                    ->limit(100),
                LinkableColumn::make('reference')
                    ->label(trans('plugins/comment::comment.responsed_to'))
                    ->orderable(false)
                    ->searchable(false)
                    ->getValueUsing(function (LinkableColumn $column) {
                        $model = $column->getItem();

                        if (class_exists($model->reference_type)
                            && ($reference = $model->reference)) {
                            return $reference->name ?? $reference->title ?? $reference->id;
                        }

                        return $model->reference_url ?: '-';
                    })
                    ->urlUsing(function (LinkableColumn $column) {
                        $model = $column->getItem();

                        $url = $model->reference_url;

                        if (class_exists($model->reference_type)
                            && ($reference = $model->reference)) {
                            $url = $reference->url;
                        }

                        return sprintf('%s#comment-%s', $url ?: '#', $model->getKey());
                    })
                    ->externalLink(),
                StatusColumn::make(),
                DateColumn::make('created_at')
                    ->label(trans('plugins/comment::comment.submitted_on'))
                    ->dateFormat('Y-m-d H:i:s'),
            ])
            ->addBulkAction(
                DeleteBulkAction::make()->permission('comment.comments.destroy'),
            )
            ->addBulkChange(
                StatusBulkChange::make()
                    ->choices(CommentStatus::labels())
                    ->validate(['required', Rule::in(CommentStatus::values())]),
            );
    }
}
