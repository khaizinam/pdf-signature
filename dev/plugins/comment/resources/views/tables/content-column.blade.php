@if($model->comment)
    <div class="mb-2">
        {!! trans('plugins/comment::comment.in_reply_to', ['name' => Html::link($url, $model->comment->name, ['target' => '_blank'])]) !!}
    </div>
@endif

{!! BaseHelper::clean($model->content) !!}
