<?php

namespace Dev\Ticksify\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Ticksify\Forms\CategoryForm;
use Dev\Ticksify\Http\Requests\CategoryRequest;
use Dev\Ticksify\Models\Category;
use Dev\Ticksify\Tables\CategoryTable;

class CategoryController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ticksify::ticksify.name'))
            ->add(
                trans('plugins/ticksify::ticksify.categories.name'),
                route('ticksify.categories.index')
            );
    }

    public function index(CategoryTable $categoryTable)
    {
        $this->pageTitle(trans('plugins/ticksify::ticksify.categories.name'));

        return $categoryTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('core/base::forms.create'));

        return CategoryForm::create()->renderForm();
    }

    public function store(CategoryRequest $request)
    {
        $form = CategoryForm::create()->setRequest($request);
        $form->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousRoute('ticksify.categories.index')
            ->setNextRoute(
                'ticksify.categories.edit',
                $form->getModel()->getKey()
            )
            ->withCreatedSuccessMessage();
    }

    public function edit(Category $category)
    {
        $this->pageTitle(trans('core/base::forms.edit'));

        return CategoryForm::createFromModel($category)->renderForm();
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $form = CategoryForm::createFromModel($category)->setRequest($request);
        $form->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousRoute('ticksify.categories.index')
            ->setNextRoute(
                'ticksify.categories.edit',
                $form->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Category $category)
    {
        return DeleteResourceAction::make($category);
    }
}
