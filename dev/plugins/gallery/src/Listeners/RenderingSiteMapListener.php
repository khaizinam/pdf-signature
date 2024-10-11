<?php

namespace Dev\Gallery\Listeners;

use Dev\Gallery\Facades\Gallery;
use Dev\Gallery\Models\Gallery as GalleryModel;
use Dev\Theme\Events\RenderingSiteMapEvent;
use Dev\Theme\Facades\SiteMapManager;

class RenderingSiteMapListener
{
    public function handle(RenderingSiteMapEvent $event): void
    {
        $lastUpdated = GalleryModel::query()
            ->wherePublished()
            ->latest('updated_at')
            ->value('updated_at');

        if ($event->key == 'galleries') {
            SiteMapManager::add(Gallery::getGalleriesPageUrl(), $lastUpdated, '0.8', 'weekly');

            $galleries = GalleryModel::query()
                ->with('slugable')
                ->wherePublished()
                ->orderBy('order')
                ->select(['id', 'name', 'updated_at'])
                ->orderByDesc('created_at')
                ->get();

            foreach ($galleries as $gallery) {
                SiteMapManager::add($gallery->url, $gallery->updated_at, '0.8');
            }

            return;
        }

        SiteMapManager::addSitemap(SiteMapManager::route('galleries'), $lastUpdated);
    }
}
