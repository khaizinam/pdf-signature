<?php

namespace Dev\Gallery\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Gallery\Facades\Gallery;
use Dev\Gallery\Models\Gallery as GalleryModel;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Theme\Facades\Theme;

class PublicController extends BaseController
{
    public function getGalleries()
    {
        $galleries = GalleryModel::query()
            ->wherePublished()
            ->with(['slugable', 'user'])
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->get();

        SeoHelper::setTitle(__('Galleries'));

        Theme::breadcrumb()->add(__('Galleries'), Gallery::getGalleriesPageUrl());

        return Theme::scope('galleries', compact('galleries'), 'plugins/gallery::themes.galleries')
            ->render();
    }
}
