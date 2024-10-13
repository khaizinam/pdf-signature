<?php

namespace Theme\Main\Http\Controllers;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\ContractManagement\Models\ContractManagement;
use Dev\ContractManagement\Models\Signature;
use Dev\ContractManagement\Repositories\Interfaces\ContractManagementInterface;
use Dev\Media\Facades\AppMedia;
use Dev\Page\Models\Page;
use Dev\Page\Services\PageService;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Slug\Facades\SlugHelper;
use Dev\Slug\Models\Slug;
use Dev\Theme\Events\RenderingHomePageEvent;
use Dev\Theme\Events\RenderingSingleEvent;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends PublicController
{

    public function getIndex()
    {
        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            $homepageId = BaseHelper::getHomepageId();
            if ($homepageId) {
                $slug = SlugHelper::getSlug(null, SlugHelper::getPrefix(Page::class), Page::class, $homepageId);
                if ($slug) {
                    $data = (new PageService)->handleFrontRoutes($slug);
                    Theme::layout('default');
                    return Theme::scope('index', $data['data'])->render();
                }
            }
        }
        SeoHelper::setTitle(theme_option('seo_title'))
            ->setDescription(theme_option('seo_description'))
            ->openGraph()
            ->setTitle(@theme_option('seo_title'))
            ->setSiteName(@theme_option('site_title'))
            ->setUrl(route('public.index'))
            ->setImage(AppMedia::getImageUrl(theme_option('seo_og_image'), 'og'))
            ->addProperty('image:width', '1200')
            ->addProperty('image:height', '630');

        Theme::breadcrumb()->add(__('Home'), route('public.index'));

        event(RenderingHomePageEvent::class);
    }

    public function getContractView(string $key = null)
    {

        if (empty($key)) {
            return $this->getIndex();
        }

        $slug = SlugHelper::getSlug($key, SlugHelper::getPrefix(ContractManagement::class));

        $page = Page::query()->where('template', 'contract')->first();

        $pageSlug = Slug::query()->where('reference_type', Page::class)->where('reference_id', $page->id)->first();

        if (!$slug || !$page || !$pageSlug) {
            abort(404);
        }

        if ($slug->reference_type != ContractManagement::class) {
            abort(404);
        }

        $contract = app(ContractManagementInterface::class)->findById($slug->reference_id);
        SeoHelper::setTitle(Arr::get($contract, 'name', ''))
            ->setDescription(Arr::get($contract, 'name', ''))
            ->openGraph()
            ->setTitle(Arr::get($contract, 'name', ''))
            ->setSiteName(Arr::get($contract, 'name', ''))
            ->setUrl(route('public.contract-view', $key));

        event(new RenderingSingleEvent($slug));

        Theme::layout('contract');
        $this->deleteAllSignatures();
        return Theme::scope('contract', compact('contract', 'page', 'pageSlug'))->render();
    }

    public function getView(?string $key = null, string $prefix = '')
    {
        if (empty($key)) {
            return $this->getIndex();
        }

        $slug = SlugHelper::getSlug($key, '');

        if (!$slug) {
            abort(404);
        }

        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            if ($slug->reference_type == Page::class && BaseHelper::isHomepage($slug->reference_id)) {
                return redirect()->to('/');
            }
        }

        $result = apply_filters(BASE_FILTER_PUBLIC_SINGLE_DATA, $slug);

        if (isset($result['slug']) && $result['slug'] !== $key) {
            return redirect()->route('public.single', $result['slug']);
        }

        $page = Arr::get($result, 'data.page');

        SeoHelper::setTitle(Arr::get($page, 'name', ''))
            ->setDescription(Arr::get($page, 'description', ''))
            ->openGraph()
            ->setTitle(Arr::get($page, 'name', ''))
            ->setSiteName(Arr::get($page, 'name', ''))
            ->setUrl(route('public.index', $key))
            ->setImage(get_object_image(Arr::get($page, 'image', '')))
            ->addProperty('image:width', '1200')
            ->addProperty('image:height', '630');

        event(new RenderingSingleEvent($slug));
        Theme::layout('default');

        if (!empty($result) && is_array($result)) {
            $view = Arr::get($result, 'data.page')->template ?? Arr::get($result, 'view', '');
            return Theme::scope($view, $result['data'], Arr::get($result, 'default_view'))->render();
        }
        abort(404);
        Theme::breadcrumb()->add(__('Trang chủ'), url("public.index"));
    }

    public function getSiteMapIndex(string $key = null, string $extension = 'xml')
    {
        return parent::getSiteMapIndex();
    }


    public function saveSignature(HttpRequest $request)
    {
        // Xóa tất cả các tệp hình ảnh chữ ký cũ (nếu cần)
        $this->deleteOldSignatures();

        $image = $request->image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'signature_' . time() . '.png';

        Storage::disk('public')->put($imageName, base64_decode($image));

        // Trả về đường dẫn của chữ ký vừa được lưu
        $imageUrl = Storage::disk('public')->url($imageName);

        return response()->json(['success' => true, 'image' => $imageUrl]);
    }


    private function deleteOldSignatures()
    {
        $files = Storage::disk('public')->files();

        foreach ($files as $file) {
            if (preg_match('/signature_(\d+)\.png/', $file)) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    public function loadSignature()
    {


        $files = Storage::disk('public')->files();
        $signatures = [];

        foreach ($files as $file) {
            if (preg_match('/signature_(\d+)\.png/', $file)) {
                $signatures[] = $file;
            }
        }

        usort($signatures, function ($a, $b) {
            return filemtime(Storage::disk('public')->path($b)) - filemtime(Storage::disk('public')->path($a));
        });

        $latestImage = !empty($signatures) ? Storage::disk('public')->url($signatures[0]) : '';

        return response()->json(['image' => $latestImage]);
    }

    private function deleteAllSignatures()
    {
        $files = Storage::disk('public')->files();

        foreach ($files as $file) {
            if (preg_match('/signature_(\d+)\.png/', $file)) {
                Storage::disk('public')->delete($file);
            }
        }
    }


    public function saveSignatureContract(HttpRequest $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf',
            ]);
            $signature = new Signature();
            $signature->name = $request->input('name');
            $signature->file = $request->file('file')->store('signatures');
            $signature->contract_id = $request->input('contract_id');
            $signature->save();

            return response()->json(['success' => true, 'message' => 'Chữ ký đã được lưu!']);
        } catch (\Exception $th) {
            return response()->json(['success' => true, 'message' =>  $th->getMessage()])->status(500);
        }

    }


}
