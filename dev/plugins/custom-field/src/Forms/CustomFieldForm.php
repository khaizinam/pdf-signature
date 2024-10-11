<?php

namespace Dev\CustomField\Forms;

use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\SortOrderFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\CustomField\Facades\CustomField;
use Dev\CustomField\Http\Requests\CreateFieldGroupRequest;
use Dev\CustomField\Models\FieldGroup;
use Dev\CustomField\Repositories\Interfaces\FieldGroupInterface;

class CustomFieldForm extends FormAbstract
{
    public function __construct(protected FieldGroupInterface $fieldGroupRepository)
    {
        parent::__construct();
    }

    public function setup(): void
    {
        $model = $this->getModel();
        $customFieldItems = [];

        if ($model) {
            $customFieldItems = $this->fieldGroupRepository->getFieldGroupItems($this->getModel()->id);
        }

        add_filter('base_action_form_actions_extra', function (string $html) use ($model): string {
            if (! $model) {
                return $html;
            }

            return $html . view('plugins/custom-field::_partials.export-button', compact('model'));
        });

        $this
            ->model(FieldGroup::class)
            ->setValidatorClass(CreateFieldGroupRequest::class)
            ->setFormOption('class', 'form-update-field-group')
            ->add('title', TextField::class, NameFieldOption::make()->label(trans('core/base::forms.title'))->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->add('order', NumberField::class, SortOrderFieldOption::make()->toArray())
            ->setBreakFieldPoint('status')
            ->addMetaBoxes([
                'rules' => [
                    'title' => trans('plugins/custom-field::base.form.rules.rules'),
                    'content' => view('plugins/custom-field::rules', [
                        'object' => $this->getModel(),
                        'customFieldItems' => json_encode($customFieldItems),
                        'rules_template' => CustomField::renderRules(),
                    ])->render(),
                ],
                'field-items-list' => [
                    'title' => trans('plugins/custom-field::base.form.field_items_information'),
                    'content' => view('plugins/custom-field::field-items-list')->render(),
                ],
            ]);
    }
}
