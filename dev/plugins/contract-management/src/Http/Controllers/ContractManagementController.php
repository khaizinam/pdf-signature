<?php

namespace Dev\ContractManagement\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\ContractManagement\Http\Requests\ContractManagementRequest;
use Dev\ContractManagement\Models\ContractManagement;
use Dev\Base\Facades\PageTitle;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\ContractManagement\Tables\ContractManagementTable;
use Dev\ContractManagement\Forms\ContractManagementForm;
use Dev\ContractManagement\Repositories\Interfaces\ContractManagementInterface;
use Illuminate\Http\Request;

class ContractManagementController extends BaseController
{
    protected ContractManagementInterface $repository;

    public function __construct(ContractManagementInterface $repository)
    {
        $this->repository = $repository;
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/contract-management::contract-management.name')), route('contract-management.index'));
    }

    public function index(ContractManagementTable $table)
    {
        $this->pageTitle(trans('plugins/contract-management::contract-management.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/contract-management::contract-management.create'));

        return ContractManagementForm::create()->renderForm();
    }

    public function store(ContractManagementRequest $request)
    {
        $form = ContractManagementForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('contract-management.index'))
            ->setNextUrl(route('contract-management.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(ContractManagement $contractManagement)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $contractManagement->name]));

        return ContractManagementForm::createFromModel($contractManagement)->renderForm();
    }

    public function update(ContractManagement $contractManagement, ContractManagementRequest $request)
    {
        ContractManagementForm::createFromModel($contractManagement)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('contract-management.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $productCategory = $this->repository->findOrFail($id);
            $this->repository->delete($productCategory);
            event(new DeletedContentEvent('product', $request, $productCategory));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function destroy(ContractManagement $contractManagement)
    {
        return DeleteResourceAction::make($contractManagement);
    }
}
