<?php

namespace Dev\Table\Abstracts\Concerns;

use Dev\Base\Facades\Html;
use Dev\Media\Facades\AppMedia;
use Dev\Table\BulkActions\DeleteBulkAction;
use Illuminate\Support\HtmlString;

trait DeprecatedFunctions
{
    /**
     * @deprecated since v6.8.0, use `DeleteBulkAction::class` instead.
     */
    protected function addDeleteAction(string $url, ?string $permission = null, array $actions = []): array
    {
        return $actions + [
                DeleteBulkAction::make()->action('DELETE')->permission((string) $permission)->dispatchUrl(
                    $url
                ),
            ];
    }

    /**
     * @deprecated
     */
    protected function getCheckbox(int|string $id): string
    {
        return view('core/table::partials.checkbox', compact('id'))->render();
    }

    /**
     * @deprecated
     */
    protected function displayThumbnail(?string $image, array $attributes = ['width' => 50], bool $relative = false): HtmlString|string
    {
        if ($this->request()->has('action')) {
            if ($this->isExportingToCSV()) {
                return AppMedia::getImageUrl($image, null, $relative, AppMedia::getDefaultImage());
            }

            if ($this->isExportingToExcel()) {
                return AppMedia::getImageUrl($image, 'thumb', $relative, AppMedia::getDefaultImage());
            }
        }

        return Html::image(
            AppMedia::getImageUrl($image, 'thumb', $relative, AppMedia::getDefaultImage()),
            trans('core/base::tables.image'),
            $attributes
        );
    }
}
