<?php

return [
    [
        'name' => 'Projects',
        'flag' => 'projects.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'projects.create',
        'parent_flag' => 'projects.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'projects.edit',
        'parent_flag' => 'projects.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'projects.destroy',
        'parent_flag' => 'projects.index',
    ],
];
