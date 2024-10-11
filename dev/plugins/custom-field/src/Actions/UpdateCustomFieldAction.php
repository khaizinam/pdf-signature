<?php

namespace Dev\CustomField\Actions;

use Dev\CustomField\Forms\CustomFieldForm;
use Dev\CustomField\Models\FieldGroup;
use Dev\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Illuminate\Support\Facades\Auth;

class UpdateCustomFieldAction extends AbstractAction
{
    public function __construct(protected FieldGroupInterface $fieldGroupRepository)
    {
    }

    public function run(FieldGroup $fieldGroup, array $data): array
    {
        $form = CustomFieldForm::createFromModel($fieldGroup);

        $result = null;

        $form
            ->saving(function () use ($fieldGroup, $data, &$result) {
                $data['updated_by'] = Auth::guard()->id();
                $result = $this->fieldGroupRepository->updateFieldGroup($fieldGroup->getKey(), $data);
            });

        if (! $result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $fieldGroup->getKey(),
        ]);
    }
}
