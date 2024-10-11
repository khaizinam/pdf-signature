<?php

namespace Dev\Blog\Http\Controllers;

use Dev\ACL\Models\User;
use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Base\Supports\Breadcrumb;
use Dev\Blog\Forms\PostForm;
use Dev\Blog\Http\Requests\PostRequest;
use Dev\Blog\Models\Post;
use Dev\Blog\Services\StoreCategoryService;
use Dev\Blog\Services\StoreTagService;
use Dev\Blog\Tables\PostTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/blog::base.menu_name'))
            ->add(trans('plugins/blog::posts.menu_name'), route('posts.index'));
    }

    public function index(PostTable $dataTable)
    {
        $this->pageTitle(trans('plugins/blog::posts.menu_name'));

        return $dataTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/blog::posts.create'));

        return PostForm::create()->renderForm();
    }

    public function store(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService
    ) {
        $postForm = PostForm::create();

        $postForm->saving(function (PostForm $form) use ($request, $tagService, $categoryService) {
            $form
                ->getModel()
                ->fill([
                    ...$request->input(),
                    'author_id' => Auth::guard()->id(),
                    'author_type' => User::class,
                ])
                ->save();

            /**
             * @var Post $post
             */
            $post = $form->getModel();

            $tagService->execute($request, $post);

            $categoryService->execute($request, $post);
        });

        return $this
            ->httpResponse()
            ->setPreviousRoute('posts.index')
            ->setNextRoute('posts.edit', $postForm->getModel()->getKey())
            ->withCreatedSuccessMessage();
    }

    public function edit(Post $post)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $post->name]));

        return PostForm::createFromModel($post)->renderForm();
    }

    public function update(
        Post $post,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
    ) {
        PostForm::createFromModel($post)
            ->setRequest($request)
            ->saving(function (PostForm $form) use ($categoryService, $tagService) {
                $request = $form->getRequest();

                /**
                 * @var Post $post
                 */
                $post = $form->getModel();
                $post->fill($request->input());
                $post->save();

                $tagService->execute($request, $post);

                $categoryService->execute($request, $post);
            });

        return $this
            ->httpResponse()
            ->setPreviousRoute('posts.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Post $post)
    {
        return DeleteResourceAction::make($post);
    }

    public function getWidgetRecentPosts(Request $request): BaseHttpResponse
    {
        $limit = $request->integer('paginate', 10);
        $limit = $limit > 0 ? $limit : 10;

        $posts = Post::query()
            ->with(['slugable'])
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return $this
            ->httpResponse()
            ->setData(view('plugins/blog::widgets.posts', compact('posts', 'limit'))->render());
    }
}
