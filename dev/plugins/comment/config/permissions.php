<?php

return [
    [
        'name' => 'Comments',
        'flag' => 'comment.index',
    ],
    [
        'name' => 'List',
        'flag' => 'comment.comments.index',
        'parent_flag' => 'comment.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'comment.comments.edit',
        'parent_flag' => 'comment.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'comment.comments.destroy',
        'parent_flag' => 'comment.index',
    ],
    [
        'name' => 'Reply',
        'flag' => 'comment.comments.reply',
        'parent_flag' => 'comment.index',
    ],
    [
        'name' => 'Settings',
        'flag' => 'comment.settings',
        'parent_flag' => 'comment.index',
    ],
];
