<?php

namespace Dev\CustomField\Actions;

use Dev\Base\Events\DeletedContentEvent;
use Dev\CustomField\Models\FieldGroup;
use Dev\CustomField\Repositories\Interfaces\FieldGroupInterface;

class DeleteCustomFieldAction extends AbstractAction
{
    public function __construct(protected FieldGroupInterface $fieldGroupRepository)
    {
    }

    public function run(FieldGroup $fieldGroup): array
    {
        $result = $this->fieldGroupRepository->delete($fieldGroup);

        DeletedContentEvent::dispatch($fieldGroup::class, request(), $fieldGroup);

        if (! $result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $fieldGroup->id,
        ]);
    }
}
