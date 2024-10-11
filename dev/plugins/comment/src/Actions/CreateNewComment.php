<?php

namespace Dev\Comment\Actions;

use Dev\Base\Contracts\BaseModel;
use Dev\Base\Facades\AdminHelper;
use Dev\Comment\Enums\CommentStatus;
use Dev\Comment\Models\Comment;
use Dev\Comment\Support\CommentHelper;
use Illuminate\Http\Request;

class CreateNewComment
{
    public function __construct(protected Request $request)
    {

    }

    public function __invoke(BaseModel $reference, array $data, ?Comment $replyTo = null)
    {
        $data = [
            ...$data,
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'status' => $this->getStatus(),
            'reference_id' => $reference->getKey(),
            'reference_type' => $reference::class,
        ];

        if ($author = CommentHelper::getAuthorizedUser()) {
            $data['author_id'] ??= $author->getKey();
            $data['author_type'] ??= $author::class;
        }

        Comment::query()->create([
            ...$data,
            'reply_to' => $replyTo ? ($replyTo->reply_to ?: $replyTo->getKey()) : null,
        ]);
    }

    protected function getStatus(): string
    {
        if (AdminHelper::isInAdmin() && auth()->check()) {
            return CommentStatus::APPROVED;
        }

        return CommentHelper::commentMustBeModerated() ? CommentStatus::PENDING : CommentStatus::APPROVED;
    }
}
