<?php

namespace Dev\Comment\Http\Controllers\Fronts;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Comment\Actions\CreateNewComment;
use Dev\Comment\Enums\CommentStatus;
use Dev\Comment\Http\Requests\Fronts\ReplyCommentRequest;
use Dev\Comment\Models\Comment;

class ReplyCommentController extends BaseController
{
    public function __invoke(string|int $comment, ReplyCommentRequest $request, CreateNewComment $createNewComment)
    {
        $comment = Comment::query()
            ->where('status', CommentStatus::APPROVED)
            ->with('reference')
            ->findOrFail($comment);

        $createNewComment($comment->reference, $request->validated(), $comment);

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/comment::comment.front.comment_success_message'));
    }
}
