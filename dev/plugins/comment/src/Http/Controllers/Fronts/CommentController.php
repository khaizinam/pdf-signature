<?php

namespace Dev\Comment\Http\Controllers\Fronts;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Models\BaseModel;
use Dev\Comment\Actions\CreateNewComment;
use Dev\Comment\Actions\GetCommentReference;
use Dev\Comment\Enums\CommentStatus;
use Dev\Comment\Http\Requests\Fronts\CommentReferenceRequest;
use Dev\Comment\Http\Requests\Fronts\CommentRequest;
use Dev\Comment\Models\Comment;
use Dev\Comment\Support\CommentHelper;
use Illuminate\Database\Eloquent\Builder;

class CommentController extends BaseController
{
    public function index(CommentReferenceRequest $request, GetCommentReference $getCommentReference)
    {
        $reference = new BaseModel();

        if ($request->input('reference_type')) {
            $reference = $getCommentReference($request->input('reference_type'), $request->input('reference_id'));

            $query = Comment::query()
                ->where('reference_id', $reference->getKey())
                ->where('reference_type', $reference::class);
        } else {
            $query = Comment::query()
                ->where('reference_url', $request->input('reference_url'));
        }

        $query
            ->where(function (Builder $query) {
                $query
                    ->where('status', CommentStatus::APPROVED)
                    ->orWhere(function (Builder $query) {
                        $query->where('status', CommentStatus::PENDING)
                            ->where('ip_address', request()->ip());
                    });
            })
            ->where('reply_to', null)
            ->with(['replies'])
            ->orderBy('created_at', CommentHelper::getCommentOrder());

        $comments = apply_filters('fob_comment_list_query', $query, $request)->paginate(10);

        $count = CommentHelper::getCommentsCount($reference);

        $view = apply_filters('fob_comment_list_view_path', 'plugins/comment::partials.list');

        return $this
            ->httpResponse()
            ->setData([
                'title' => trans_choice('plugins/comment::comment.front.list.title', $count, ['count' => $count]),
                'html' => view($view, compact('comments'))->render(),
                'comments' => $comments,
            ]);
    }

    public function store(
        CommentRequest $request,
        CreateNewComment $createNewComment,
        GetCommentReference $getCommentReference
    ) {
        $data = [
            ...$request->validated(),
            'reference_url' => $request->input('reference_url') ?? url()->previous(),
        ];

        $reference = new BaseModel();

        if ($request->input('reference_type')) {
            $reference = $getCommentReference($request->input('reference_type'), $request->input('reference_id'));

            if ($reference->getMetaData('allow_comments', true) == '0') {
                abort(404);
            }
        }

        $createNewComment($reference, $data);

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/comment::comment.front.comment_success_message'));
    }
}
