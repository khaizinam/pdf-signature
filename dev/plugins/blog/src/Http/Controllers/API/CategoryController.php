<?php

namespace Dev\Blog\Http\Controllers\API;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Blog\Http\Resources\CategoryResource;
use Dev\Blog\Http\Resources\ListCategoryResource;
use Dev\Blog\Models\Category;
use Dev\Blog\Repositories\Interfaces\CategoryInterface;
use Dev\Blog\Supports\FilterCategory;
use Dev\Slug\Facades\SlugHelper;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * List categories
     *
     * @group Blog
     */
    public function index(Request $request)
    {
        $data = Category::query()
            ->wherePublished()
            ->orderByDesc('created_at')
            ->with(['slugable'])
            ->paginate($request->integer('per_page', 10) ?: 10);

        return $this
            ->httpResponse()
            ->setData(ListCategoryResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Filters categories
     *
     * @group Blog
     */
    public function getFilters(Request $request, CategoryInterface $categoryRepository)
    {
        $filters = FilterCategory::setFilters($request->input());
        $data = $categoryRepository->getFilters($filters);

        return $this
            ->httpResponse()
            ->setData(CategoryResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Get category by slug
     *
     * @group Blog
     * @queryParam slug Find by slug of category.
     */
    public function findBySlug(string $slug)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Category::class));

        if (! $slug) {
            return $this
                ->httpResponse()
                ->setError()
                ->setCode(404)
                ->setMessage('Not found');
        }

        $category = Category::query()
            ->with('slugable')
            ->where([
                'id' => $slug->reference_id,
                'status' => BaseStatusEnum::PUBLISHED,
            ])
            ->first();

        if (! $category) {
            return $this
                ->httpResponse()
                ->setError()
                ->setCode(404)
                ->setMessage('Not found');
        }

        return $this
            ->httpResponse()
            ->setData(new ListCategoryResource($category))
            ->toApiResponse();
    }
}
