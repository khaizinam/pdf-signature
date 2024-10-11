<?php

return [
    [
        'name' => 'Ticksify',
        'flag' => 'ticksify',
    ],
    [
        'name' => 'Tickets',
        'flag' => 'ticksify.tickets.index',
        'parent_flag' => 'ticksify',
    ],
    [
        'name' => 'View',
        'flag' => 'ticksify.tickets.show',
        'parent_flag' => 'ticksify.tickets.index',
    ],
    [
        'name' => 'Update',
        'flag' => 'ticksify.tickets.update',
        'parent_flag' => 'ticksify.tickets.index',
    ],
    [
        'name' => 'Reply',
        'flag' => 'ticksify.tickets.messages.store',
        'parent_flag' => 'ticksify.tickets.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'ticksify.tickets.destroy',
        'parent_flag' => 'ticksify.tickets.index',
    ],

    [
        'name' => 'Ticket Categories',
        'flag' => 'ticksify.categories.index',
        'parent_flag' => 'ticksify',
    ],
    [
        'name' => 'Create',
        'flag' => 'ticksify.categories.create',
        'parent_flag' => 'ticksify.categories.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'ticksify.categories.edit',
        'parent_flag' => 'ticksify.categories.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'ticksify.categories.destroy',
        'parent_flag' => 'ticksify.categories.index',
    ],

    [
        'name' => 'Messages',
        'flag' => 'ticksify.messages.index',
        'parent_flag' => 'ticksify',
    ],
    [
        'name' => 'Edit',
        'flag' => 'ticksify.messages.edit',
        'parent_flag' => 'ticksify.messages.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'ticksify.messages.destroy',
        'parent_flag' => 'ticksify.messages.index',
    ],
];
