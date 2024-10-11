<?php

namespace Dev\ContractManagement\Http\Controllers\Settings;

use Dev\Base\Forms\FormBuilder;
use Dev\ContractManagement\Forms\Settings\ContractManagementForm;
use Dev\ContractManagement\Http\Requests\Settings\ContractManagementRequest;
use Dev\Setting\Http\Controllers\SettingController;

class ContractManagementController extends SettingController
{
    public function edit(FormBuilder $formBuilder)
    {
        $this->pageTitle('Page title');

        return $formBuilder->create(ContractManagementForm::class)->renderForm();
    }

    public function update(ContractManagementRequest $request)
    {
        return $this->performUpdate($request->validated());
    }
}
