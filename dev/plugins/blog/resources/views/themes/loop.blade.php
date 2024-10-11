@foreach ($posts as $post)
    <div>
        <article>
            <div><a href="{{ $post->url }}"></a>
                <img
                    src="{{ AppMedia::getImageUrl($post->image, null, false, AppMedia::getDefaultImage()) }}"
                    alt="{{ $post->name }}"
                >
            </div>
            <header><a href="{{ $post->url }}"> {{ $post->name }}</a></header>
        </article>
    </div>
@endforeach

<div class="pagination">
    {!! $posts->withQueryString()->links() !!}
</div>
