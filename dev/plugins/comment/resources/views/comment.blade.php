@php
    Theme::asset()->add('comment-css', asset('vendor/core/plugins/comment/css/comment.css'));
    Theme::asset()->container('footer')->add('comment-js', asset('vendor/core/plugins/comment/js/comment.js'));

    Theme::registerToastNotification();

    use Dev\Comment\Forms\Fronts\CommentForm;
@endphp

<script>
    window.fobComment = {};

    window.fobComment = {
        listUrl: {{ Js::from(route('comment.public.comments.index', isset($model) ? ['reference_type' => $model::class, 'reference_id' => $model->id] : url()->current())) }},
    };
</script>

<div class="comment-list-section" style="display: none">
    <h4 class="comment-title comment-list-title"></h4>
    <div class="comment-list-wrapper"></div>
</div>

<div class="comment-form-section">
    <h4 class="comment-title comment-form-title">{{ trans('plugins/comment::comment.front.form.title') }}</h4>
    <p class="comment-form-note">{{ trans('plugins/comment::comment.front.form.description') }}</p>

    {!! CommentForm::createWithReference($model)->renderForm() !!}
</div>
