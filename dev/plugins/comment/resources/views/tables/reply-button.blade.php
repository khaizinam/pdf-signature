<x-core::button
    type="button"
    color="primary"
    class="btn-icon"
    size="sm"
    data-bs-toggle="tooltip"
    data-bs-original-title="{{ trans('plugins/comment::comment.reply') }}"
    data-url="{{ route('comment.comments.reply', $action->getItem()->getKey()) }}"
    data-modal-title="{{ trans('plugins/comment::comment.reply_modal.title', ['comment' => $action->getItem()->name]) }}"
>
    <x-core::icon
        name="ti ti-message-reply"
        data-bs-toggle="modal"
        data-bs-target="#reply-comment-modal"
    />
</x-core::button>
