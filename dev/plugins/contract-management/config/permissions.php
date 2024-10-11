<?php

return [
    [
        'name' => 'Contract managements',
        'flag' => 'contract-management.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'contract-management.create',
        'parent_flag' => 'contract-management.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'contract-management.edit',
        'parent_flag' => 'contract-management.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'contract-management.destroy',
        'parent_flag' => 'contract-management.index',
    ],
];
