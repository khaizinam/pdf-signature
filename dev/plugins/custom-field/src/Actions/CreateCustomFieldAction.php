<?php

namespace Dev\CustomField\Actions;

use Dev\CustomField\Forms\CustomFieldForm;
use Dev\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Illuminate\Support\Facades\Auth;

class CreateCustomFieldAction extends AbstractAction
{
    public function __construct(protected FieldGroupInterface $fieldGroupRepository)
    {
    }

    public function run(array $data): array
    {
        $form = CustomFieldForm::create();

        $result = null;

        $form
            ->saving(function () use ($data, &$result) {
                $data['created_by'] = Auth::guard()->id();
                $data['updated_by'] = Auth::guard()->id();

                $result = $this->fieldGroupRepository->createFieldGroup($data);
            });

        if (! $result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
