<?php

namespace Dev\Comment\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Comment\Forms\CommentForm;
use Dev\Comment\Http\Requests\CommentRequest;
use Dev\Comment\Models\Comment;
use Dev\Comment\Tables\CommentTable;

class CommentController extends BaseController
{
    public function index(CommentTable $commentTable)
    {
        $this->pageTitle(trans('plugins/comment::comment.title'));

        return $commentTable->renderTable();
    }

    public function edit(Comment $comment)
    {
        $this->pageTitle(trans('plugins/comment::comment.edit_comment'));

        return CommentForm::createFromModel($comment)->renderForm();
    }

    public function update(Comment $comment, CommentRequest $request)
    {
        CommentForm::createFromModel($comment)
            ->onlyValidatedData()
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('comment.comments.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Comment $comment)
    {
        return DeleteResourceAction::make($comment);
    }
}
