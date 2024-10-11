<?php

namespace Dev\Blog\Services;

use Dev\Blog\Models\Post;
use Dev\Blog\Services\Abstracts\StoreCategoryServiceAbstract;
use Illuminate\Http\Request;

class StoreCategoryService extends StoreCategoryServiceAbstract
{
    public function execute(Request $request, Post $post): void
    {
        $post->categories()->sync($request->input('categories', []));
    }
}
