<?php

namespace Dev\Projects\Forms;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Forms\FormAbstract;
use Dev\Projects\Http\Requests\ProjectsRequest;
use Dev\Projects\Models\Projects;

class ProjectsForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->setupModel(new Projects())
            ->setValidatorClass(ProjectsRequest::class)
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
            ->setBreakFieldPoint('status');
    }
}
