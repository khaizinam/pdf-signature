<?php

namespace Dev\Theme\Http\Controllers;

use Dev\Base\Facades\Assets;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Setting\Http\Controllers\Concerns\InteractsWithSettings;
use Dev\Theme\Events\RenderingThemeOptionSettings;
use Dev\Theme\Facades\Manager;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Facades\ThemeOption;
use Dev\Theme\Forms\CustomCSSForm;
use Dev\Theme\Forms\CustomHTMLForm;
use Dev\Theme\Forms\CustomJSForm;
use Dev\Theme\Forms\RobotsTxtEditorForm;
use Dev\Theme\Http\Requests\CustomCssRequest;
use Dev\Theme\Http\Requests\CustomHtmlRequest;
use Dev\Theme\Http\Requests\CustomJsRequest;
use Dev\Theme\Http\Requests\RobotsTxtRequest;
use Dev\Theme\Http\Requests\UpdateOptionsRequest;
use Dev\Theme\Services\ThemeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ThemeController extends BaseController
{
    use InteractsWithSettings;

    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('libs/theme::theme.appearance'));
    }

    public function index()
    {
        if (! config('libs.theme.general.display_theme_manager_in_admin_panel', true)) {
            abort(404);
        }

        $this->pageTitle(trans('libs/theme::theme.name'));

        if (File::exists(theme_path('.DS_Store'))) {
            File::delete(theme_path('.DS_Store'));
        }

        Assets::addScriptsDirectly('vendor/core/libs/theme/js/theme.js');

        $themes = Manager::getThemes();

        return view('libs/theme::list', compact('themes'));
    }

    public function getOptions(?string $id = null)
    {
        RenderingThemeOptionSettings::dispatch();

        do_action(RENDERING_THEME_OPTIONS_PAGE);

        $sections = ThemeOption::constructSections();

        if ($id) {
            $section = ThemeOption::getSection($id);

            if (! $section) {
                abort(404);
            }
        } else {
            $section = ThemeOption::getSection(Arr::first($sections)['id']);
        }

        $this->pageTitle(
            $id
                ? trans('libs/theme::theme.theme_options') . ' - ' . $section['title']
                : trans('libs/theme::theme.theme_options')
        );

        Assets::addScripts(['are-you-sure', 'jquery-ui'])
            ->addStylesDirectly('vendor/core/libs/theme/css/theme-options.css')
            ->addScriptsDirectly('vendor/core/libs/theme/js/theme-options.js');

        return view('libs/theme::options', [
            'sections' => $sections,
            'currentSection' => $section,
        ]);
    }

    public function postUpdate(UpdateOptionsRequest $request)
    {
        RenderingThemeOptionSettings::dispatch();

        foreach ($request->except(['_token', 'ref_lang', 'ref_from']) as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);

                $field = ThemeOption::getField($key);

                if ($field && Arr::get($field, 'clean_tags', true)) {
                    $value = BaseHelper::clean(strip_tags((string) $value));
                }
            }

            ThemeOption::setOption($key, $value);
        }

        ThemeOption::saveOptions();

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }

    public function postActivateTheme(Request $request, ThemeService $themeService)
    {
        if (! config('libs.theme.general.display_theme_manager_in_admin_panel', true)) {
            abort(404);
        }

        $result = $themeService->activate($request->input('theme'));

        return $this
            ->httpResponse()
            ->setError($result['error'])
            ->setMessage($result['message']);
    }

    public function getCustomCss()
    {
        $this->pageTitle(trans('libs/theme::theme.custom_css'));

        return CustomCSSForm::create()->renderForm();
    }

    public function postCustomCss(CustomCssRequest $request)
    {
        File::delete(theme_path(Theme::getThemeName() . '/public/css/style.integration.css'));

        $file = Theme::getStyleIntegrationPath();
        $css = $request->input('custom_css');
        $css = strip_tags((string) $css);

        if (empty($css)) {
            File::delete($file);
        } else {
            $saved = BaseHelper::saveFileData($file, $css, false);

            if (! $saved) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage(
                        trans('libs/theme::theme.folder_is_not_writeable', ['name' => File::dirname($file)])
                    );
            }
        }

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }

    public function getCustomJs()
    {
        if (! config('libs.theme.general.enable_custom_js')) {
            abort(404);
        }

        $this->pageTitle(trans('libs/theme::theme.custom_js'));

        return CustomJSForm::create()->renderForm();
    }

    public function postCustomJs(CustomJsRequest $request)
    {
        if (! config('libs.theme.general.enable_custom_js')) {
            abort(404);
        }

        return $this->performUpdate($request->validated());
    }

    public function postRemoveTheme(Request $request, ThemeService $themeService)
    {
        if (! config('libs.theme.general.display_theme_manager_in_admin_panel', true)) {
            abort(404);
        }

        $theme = strtolower($request->input('theme'));

        if (in_array($theme, BaseHelper::scanFolder(theme_path()))) {
            try {
                $result = $themeService->remove($theme);

                return $this
                    ->httpResponse()
                    ->setError($result['error'])
                    ->setMessage($result['message']);
            } catch (Exception $exception) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage($exception->getMessage());
            }
        }

        return $this
            ->httpResponse()
            ->setError()
            ->setMessage(trans('libs/theme::theme.theme_is_not_existed'));
    }

    public function getCustomHtml()
    {
        if (! config('libs.theme.general.enable_custom_html')) {
            abort(404);
        }

        $this->pageTitle(trans('libs/theme::theme.custom_html'));

        return CustomHTMLForm::create()->renderForm();
    }

    public function postCustomHtml(CustomHtmlRequest $request)
    {
        if (! config('libs.theme.general.enable_custom_html')) {
            abort(404);
        }

        $data = [];

        foreach ($request->validated() as $key => $value) {
            $data[$key] = BaseHelper::clean($value);
        }

        return $this->performUpdate($data);
    }

    public function getRobotsTxt()
    {
        if (! config('libs.theme.general.enable_robots_txt_editor')) {
            abort(404);
        }

        $this->pageTitle(trans('libs/theme::theme.robots_txt_editor'));

        return RobotsTxtEditorForm::create()->renderForm();
    }

    public function postRobotsTxt(RobotsTxtRequest $request)
    {
        if (! config('libs.theme.general.enable_robots_txt_editor')) {
            abort(404);
        }

        $path = public_path('robots.txt');

        if (! File::isWritable($path)) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(trans('libs/theme::theme.robots_txt_not_writable', ['path' => $path]));
        }

        File::put($path, $request->input('robots_txt_content'));

        if ($request->hasFile('robots_txt_file')) {
            $request->file('robots_txt_file')->move(public_path(), 'robots.txt');
        }

        return $this->httpResponse()->withUpdatedSuccessMessage();
    }
}
