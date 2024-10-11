<script>
    "use strict";
    
    var APP_MEDIA_URL = {{ Js::from(AppMedia::getUrls()) }};

    var APP_MEDIA_CONFIG = {{ Js::from([
        'permissions' => AppMedia::getPermissions(),
        'translations' => trans('core/media::media.javascript'),
        'pagination' => [
            'paged' => AppMedia::getConfig('pagination.paged'),
            'posts_per_page' => AppMedia::getConfig('pagination.per_page'),
            'in_process_get_media' => false,
            'has_more' => true,
        ],
        'chunk' => AppMedia::getConfig('chunk'),
        'random_hash' => setting('media_random_hash') ?: null,
        'default_image' => AppMedia::getDefaultImage(),
    ]) }};

    APP_MEDIA_CONFIG.translations.actions_list.other.properties = '{{ trans('core/media::media.javascript.actions_list.other.properties') }}';
</script>
