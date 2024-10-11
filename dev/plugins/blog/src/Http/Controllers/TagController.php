<?php

namespace Dev\Blog\Http\Controllers;

use Dev\ACL\Models\User;
use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Blog\Forms\TagForm;
use Dev\Blog\Http\Requests\TagRequest;
use Dev\Blog\Models\Tag;
use Dev\Blog\Tables\TagTable;
use Illuminate\Support\Facades\Auth;

class TagController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/blog::base.menu_name'))
            ->add(trans('plugins/blog::tags.menu'), route('tags.index'));
    }

    public function index(TagTable $dataTable)
    {
        $this->pageTitle(trans('plugins/blog::tags.menu'));

        return $dataTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/blog::tags.create'));

        return TagForm::create()->renderForm();
    }

    public function store(TagRequest $request)
    {
        $form = TagForm::create();

        $form
            ->saving(function (TagForm $form) use ($request) {
                $form
                    ->getModel()
                    ->fill([...$request->validated(),
                        'author_id' => Auth::guard()->id(),
                        'author_type' => User::class,
                    ])
                    ->save();
            });

        return $this
            ->httpResponse()
            ->setPreviousRoute('tags.index')
            ->setNextRoute('tags.edit', $form->getModel()->getKey())
            ->withCreatedSuccessMessage();
    }

    public function edit(Tag $tag)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $tag->name]));

        return TagForm::createFromModel($tag)->renderForm();
    }

    public function update(Tag $tag, TagRequest $request)
    {
        TagForm::createFromModel($tag)->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('tags.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Tag $tag)
    {
        return DeleteResourceAction::make($tag);
    }

    public function getAllTags()
    {
        return Tag::query()->pluck('name')->all();
    }
}
