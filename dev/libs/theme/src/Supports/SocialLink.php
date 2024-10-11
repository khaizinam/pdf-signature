<?php

namespace Dev\Theme\Supports;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Facades\Html;
use Dev\Media\Facades\AppMedia;
use Illuminate\Support\HtmlString;

class SocialLink
{
    public function __construct(
        protected ?string $name,
        protected ?string $url,
        protected ?string $icon,
        protected ?string $image,
        protected ?string $color,
        protected ?string $backgroundColor,
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getColor(): ?string
    {
        if ($this->color === 'transparent') {
            return null;
        }

        return $this->color;
    }

    public function getBackgroundColor(): ?string
    {
        if ($this->backgroundColor === 'transparent') {
            return null;
        }

        return $this->backgroundColor;
    }

    public function getAttributes(array $attributes = []): HtmlString
    {
        $backgroundColor = $this->getBackgroundColor();
        $color = $this->getColor();

        $attributes = [
            'href' => $this->getUrl(),
            'title' => $this->getName(),
            'target' => '_blank',
            'style' => ($backgroundColor ? sprintf('background-color: %s !important;', $backgroundColor) : null) .
                ($color ? sprintf('color: %s !important;', $color) : null),
            ...$attributes,
        ];

        if (! $attributes['style']) {
            unset($attributes['style']);
        }

        return new HtmlString(Html::attributes($attributes));
    }

    public function getIconHtml(array $attributes = []): ?HtmlString
    {
        if ($this->image) {

            $attributes = [
                'loading' => false,
                ...$attributes,
            ];

            return AppMedia::image($this->image, $this->name, attributes: $attributes);
        }

        if (! $this->icon) {
            return null;
        }

        if (BaseHelper::hasIcon($this->icon)) {
            $icon = BaseHelper::renderIcon($this->icon, attributes: $attributes);
        } else {
            $icon = BaseHelper::clean(sprintf('<i class="%s"></i>', $this->icon));
        }

        return new HtmlString($icon);
    }
}
