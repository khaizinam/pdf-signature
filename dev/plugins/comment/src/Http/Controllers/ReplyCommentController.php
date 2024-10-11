<?php

namespace Dev\Comment\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Comment\Actions\CreateNewComment;
use Dev\Comment\Enums\CommentStatus;
use Dev\Comment\Http\Requests\ReplyCommentRequest;
use Dev\Comment\Models\Comment;

class ReplyCommentController extends BaseController
{
    public function __invoke(Comment $comment, CreateNewComment $createNewComment, ReplyCommentRequest $request)
    {
        $comment->loadMissing('reference');
        $user = $request->user();

        $createNewComment($comment->reference, [
            ...$request->validated(),
            'status' => CommentStatus::APPROVED,
            'author_type' => $user::class,
            'author_id' => $user->getKey(),
            'name' => $user->name,
            'email' => $user->email,
        ], $comment);

        return $this->httpResponse();
    }
}
