<?php

namespace Dev\ContractManagement\Forms\Settings;

use Dev\ContractManagement\Http\Requests\Settings\ContractManagementRequest;
use Dev\Setting\Forms\SettingForm;

class ContractManagementForm extends SettingForm
{
    public function buildForm(): void
    {
        parent::buildForm();

        $this
            ->setSectionTitle('Setting title')
            ->setSectionDescription('Setting description')
            ->setValidatorClass(ContractManagementRequest::class);
    }
}
