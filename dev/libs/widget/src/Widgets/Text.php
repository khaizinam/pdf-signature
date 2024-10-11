<?php

namespace Dev\Widget\Widgets;

use Dev\Widget\AbstractWidget;

class Text extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => trans('libs/widget::widget.widget_text'),
            'description' => trans('libs/widget::widget.widget_text_description'),
            'content' => null,
        ]);

        $widgetDirectory = $this->getWidgetDirectory();

        $this->setFrontendTemplate('libs/widget::widgets.' . $widgetDirectory . '.frontend');
        $this->setBackendTemplate('libs/widget::widgets.' . $widgetDirectory . '.backend');
    }

    public function getWidgetDirectory(): string
    {
        return 'text';
    }
}
