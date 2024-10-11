<?php

namespace Dev\ContractManagement\Forms;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Forms\Fields\MediaFileField;
use Dev\Base\Forms\FormAbstract;
use Dev\ContractManagement\Http\Requests\ContractManagementRequest;
use Dev\ContractManagement\Models\ContractManagement;
use Dev\Base\Forms\Fields\MediaImageField;

class ContractManagementForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->setupModel(new ContractManagement())
            ->setValidatorClass(ContractManagementRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('file', MediaFileField::class)
            ->setBreakFieldPoint('status');
    }
}
