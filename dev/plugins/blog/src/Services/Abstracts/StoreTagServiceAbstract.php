<?php

namespace Dev\Blog\Services\Abstracts;

use Dev\Blog\Models\Post;
use Illuminate\Http\Request;

abstract class StoreTagServiceAbstract
{
    abstract public function execute(Request $request, Post $post): void;
}
