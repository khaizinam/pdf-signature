<?php

return [
    'supported' => [
        'page' => Dev\Page\Models\Page::class,
        'post' => Dev\Blog\Models\Post::class,
    ],
    'use_cache' => true,
    'interval' => 90,
];
