<?php

namespace Dev\Widget\Http\Controllers;

use Dev\Base\Facades\Assets;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Widget\Events\RenderingWidgetSettings;
use Dev\Widget\Facades\WidgetGroup;
use Dev\Widget\Models\Widget;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class WidgetController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('libs/theme::theme.appearance'))
            ->add(trans('libs/widget::widget.name'), route('widgets.index'));
    }

    public function index()
    {
        $this->pageTitle(trans('libs/widget::widget.name'));

        Assets::addScripts(['sortable'])
            ->addScriptsDirectly('vendor/core/libs/widget/js/widget.js')
            ->addStylesDirectly('vendor/core/libs/widget/css/widget.css');

        RenderingWidgetSettings::dispatch();

        $widgets = Widget::query()->where('theme', Widget::getThemeName())->get();

        $groups = WidgetGroup::getGroups();
        foreach ($widgets as $widget) {
            if (! Arr::has($groups, $widget->sidebar_id)) {
                continue;
            }

            WidgetGroup::group($widget->sidebar_id)
                ->position($widget->position)
                ->addWidget($widget->widget_id, $widget->data);
        }

        return view('libs/widget::list');
    }

    public function update(Request $request)
    {
        try {
            $sidebarId = $request->input('sidebar_id');

            $themeName = Widget::getThemeName();

            Widget::query()->where([
                'sidebar_id' => $sidebarId,
                'theme' => $themeName,
            ])->delete();

            foreach (array_filter($request->input('items', [])) as $key => $item) {

                parse_str($item, $data);

                if (empty($data['id'])) {
                    continue;
                }

                Widget::query()->create([
                    'sidebar_id' => $sidebarId,
                    'widget_id' => $data['id'],
                    'theme' => $themeName,
                    'position' => $key,
                    'data' => $data,
                ]);
            }

            $widgetAreas = Widget::query()->where([
                'sidebar_id' => $sidebarId,
                'theme' => $themeName,
            ])->get();

            return $this
                ->httpResponse()
                ->setData(view('libs/widget::item', compact('widgetAreas'))->render())
                ->setMessage(trans('libs/widget::widget.save_success'));
        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            Widget::query()->where([
                'theme' => Widget::getThemeName(),
                'sidebar_id' => $request->input('sidebar_id'),
                'position' => $request->input('position'),
                'widget_id' => $request->input('widget_id'),
            ])->delete();

            $sidebarId = $request->input('sidebar_id');

            $themeName = Widget::getThemeName();

            $widgetAreas = Widget::query()->where([
                'sidebar_id' => $sidebarId,
                'theme' => $themeName,
            ])->get();

            return $this
                ->httpResponse()
                ->setData(view('libs/widget::item', compact('widgetAreas'))->render())
                ->setMessage(trans('libs/widget::widget.delete_success'));
        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
