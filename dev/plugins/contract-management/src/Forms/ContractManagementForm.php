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
        $signatureLst = [];

        if ($this->getModel()) {
            $signatureLst = $this->getModel()->signatures()->get();
        }
        // dd($signatureLst);

        $this
            ->setupModel(new ContractManagement())
            ->setValidatorClass(ContractManagementRequest::class)
            ->withCustomFields()
            ->addCustomField('signatureMulti', SignatureFormField::class)
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('file', MediaFileField::class)
            ->add('signature', 'signatureMulti', [
                'label' => trans('Lịch sử đã ký'),
                'values' => $signatureLst,
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
