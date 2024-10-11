<?php

use Dev\Menu\Models\Menu;
use Dev\Menu\Models\MenuNode;
use Dev\Page\Models\Page;

return [
    'supported' => [
        Page::class,
        Menu::class,
        MenuNode::class,
    ],
];
