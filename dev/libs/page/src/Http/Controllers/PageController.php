<?php

namespace Dev\Page\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Page\Forms\PageForm;
use Dev\Page\Http\Requests\PageRequest;
use Dev\Page\Models\Page;
use Dev\Page\Tables\PageTable;
use Illuminate\Support\Facades\Auth;

class PageController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('libs/page::pages.menu_name'), route('pages.index'));
    }

    public function index(PageTable $pageTable)
    {
        $this->pageTitle(trans('libs/page::pages.menu_name'));

        return $pageTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('libs/page::pages.create'));

        return PageForm::create()->renderForm();
    }

    public function store(PageRequest $request)
    {
        $form = PageForm::create()->setRequest($request);

        $form->saving(function (PageForm $form) {
            $form
                ->getModel()
                ->fill([...$form->getRequest()->input(), 'user_id' => Auth::guard()->id()])
                ->save();
        });

        return $this
            ->httpResponse()
            ->setPreviousRoute('pages.index')
            ->setNextRoute('pages.edit', $form->getModel()->getKey())
            ->withCreatedSuccessMessage();
    }

    public function edit(Page $page)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $page->name]));

        return PageForm::createFromModel($page)->renderForm();
    }

    public function update(Page $page, PageRequest $request)
    {
        PageForm::createFromModel($page)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('pages.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Page $page)
    {
        return DeleteResourceAction::make($page);
    }
}
