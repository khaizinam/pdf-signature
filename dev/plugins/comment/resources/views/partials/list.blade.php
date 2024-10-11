@php
    $currentIndent ??= 0;

    if (! view()->exists($paginationView = Theme::getThemeNamespace('partials.pagination'))) {
        $paginationView = 'pagination::bootstrap-5';
    }
@endphp

<div class="comment-list">
    @foreach($comments as $comment)
        @continue(! $comment->is_approved && $comment->ip_address !== request()->ip())

        <div id="comment-{{ $comment->getKey() }}" class="comment-item">
            <div class="comment-item-inner">
                <div class="comment-item-avatar">
                    @if ($comment->website)
                        <a href="{{ $comment->website }}" target="_blank">
                            <img src="{{ $comment->avatar_url }}" alt="{{ $comment->name }}">
                        </a>
                    @else
                        <img src="{{ $comment->avatar_url }}" alt="{{ $comment->name }}">
                    @endif
                </div>
                <div class="comment-item-content">
                    <div class="comment-item-body">
                        @if (! $comment->is_approved)
                            <em class="comment-item-pending">
                                {{ trans('plugins/comment::comment.front.list.waiting_for_approval_message') }}
                            </em>
                        @endif
                        @if($comment->is_admin)
                            {!! BaseHelper::clean($comment->formatted_content) !!}
                        @else
                            <p>{{ $comment->formatted_content }}</p>
                        @endif
                    </div>

                    <div class="comment-item-footer">
                        <div class="comment-item-info">
                            @if(\Dev\Comment\Support\CommentHelper::isDisplayAdminBadge() && $comment->is_admin)
                                <span class="comment-item-admin-badge">
                                    {{ trans('plugins/comment::comment.front.admin_badge') }}
                                </span>
                            @endif
                            @if ($comment->website)
                                <a href="{{ $comment->website }}" class="comment-item-author" target="_blank">
                                    <h4 class="comment-item-author">{{ $comment->name }}</h4>
                                </a>
                            @else
                                <h4 class="comment-item-author">{{ $comment->name }}</h4>
                            @endif
                            <span class="comment-item-date">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        @if ($comment->is_approved)
                            <a
                                href="{{ route('comment.public.comments.reply', $comment) }}"
                                class="comment-item-reply"
                                data-comment-id="{{ $comment->getKey() }}"
                                data-reply-to="{{ $replyLabel = trans('plugins/comment::comment.front.list.reply_to', ['name' => $comment->name]) }}"
                                data-cancel-reply="{{ trans('plugins/comment::comment.front.list.cancel_reply') }}"
                                aria-label="{{ $replyLabel }}"
                            >
                                {{ trans('plugins/comment::comment.front.list.reply') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @if ($comment->replies->count())
                @include('plugins/comment::partials.list', [
                    'comments' => $comment->replies,
                    'currentIndent' => $currentIndent + 1,
                ])
            @endif
        </div>
    @endforeach
</div>

@if ($comments instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $comments->hasPages())
    <div class="comment-pagination">
        {{ $comments->appends(request()->except('page'))->links($paginationView) }}
    </div>
@endif
