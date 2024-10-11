<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>

@foreach (AppMedia::getConfig('libraries.stylesheets', []) as $css)
    <link
        type="text/css"
        href="{{ asset($css) }}?v={{ get_cms_version() }}"
        rel="stylesheet"
    />
@endforeach

@include('core/media::config')
